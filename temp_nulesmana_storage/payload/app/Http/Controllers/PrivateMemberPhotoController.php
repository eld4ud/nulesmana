<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Support\NulesmanaMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

/** The browser never sees an S3 secret or a public URL for a member photo. */
final class PrivateMemberPhotoController extends Controller
{
    public function show(Request $request, Member $member)
    {
        $user = $request->user();
        $isAdmin = $user && $user->role === 'admin';
        $isOwner = $user
            && $user->role === 'member'
            && $user->status === 'approved'
            && $member->status === 'approved'
            && (int) $member->user_id === (int) $user->id;

        abort_unless($isAdmin || $isOwner, 404);
        abort_unless(filled($member->photo), 404);

        $path = (string) $member->photo;
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $types = [
            'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png', 'webp' => 'image/webp',
        ];
        abort_unless(isset($types[$extension]), 404);

        try {
            $stream = Storage::disk(NulesmanaMedia::memberDisk())->readStream($path);
        } catch (Throwable) {
            abort(404);
        }
        abort_unless(is_resource($stream), 404);

        return response()->stream(function () use ($stream): void {
            try {
                fpassthru($stream);
            } finally {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $types[$extension],
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
