<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:80',
            'rating' => 'required|integer|between:1,5',
            'message' => 'required|string|min:10|max:2000',
        ]);

        if (!Schema::hasTable('reviews')) {
            return back()->with(
                'error',
                'Fitur ulasan belum siap. Hubungi admin.'
            );
        }

        $user = $request->user();

        Review::create([
            'user_id' => $user?->id,
            'name' => $user
                ? $user->name
                : ($validated['name'] ?? 'Anonim'),
            'rating' => $validated['rating'],
            'message' => $validated['message'],
            'is_visible' => true,
            'is_verified_member' => false,
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Ulasan berhasil dikirim!');
    }
}
