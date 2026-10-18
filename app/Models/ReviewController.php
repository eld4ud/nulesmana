<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:80'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $user = $request->user();
        Review::create([
            'user_id' => $user?->id,
            'name' => $user?->name ?: (trim($validated['name'] ?? '') ?: 'Anonim'),
            'rating' => $validated['rating'],
            'message' => $validated['message'],
            'is_visible' => true,
            // Jangan beri badge terverifikasi sampai relasi anggota yang disetujui diperiksa.
            'is_verified_member' => false,
        ]);

        return redirect()->route('home', ['#' => 'saran'])->with('success', 'Ulasan berhasil dipublikasikan. Terima kasih!');
    }
}
