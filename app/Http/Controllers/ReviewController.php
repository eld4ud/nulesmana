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

        if (! Schema::hasTable('reviews')) {
            return back()->with('error', 'Fitur ulasan belum siap. Hubungi admin.');
        }

        $user = $request->user();
        $review = Review::create([
            'user_id' => $user?->id,
            'name' => $user ? $user->name : ($validated['name'] ?? 'Anonim'),
            'rating' => $validated['rating'],
            'message' => $validated['message'],
            'is_visible' => true,
            'is_verified_member' => (bool) ($user && $user->role === 'member' && $user->status === 'approved'),
        ]);

        if (! $user) {
            $request->session()->push('review_owned_ids', (int) $review->id);
        }

        return redirect()->route('home')->withFragment('saran')
            ->with('success', 'Ulasan berhasil dikirim!');
    }

    public function destroyOwn(Request $request, Review $review)
    {
        $user = $request->user();
        $ownAccount = $user && $review->user_id !== null
            && (int) $review->user_id === (int) $user->id;

        $guestIds = array_map('intval', (array) $request->session()->get('review_owned_ids', []));
        $ownGuestSession = $review->user_id === null
            && in_array((int) $review->id, $guestIds, true);

        abort_unless($ownAccount || $ownGuestSession, 403);
        $reviewId = (int) $review->id;
        $review->delete();
        $request->session()->put('review_owned_ids', array_values(array_filter(
            $guestIds, fn (int $id) => $id !== $reviewId
        )));

        return redirect()->route('home')->withFragment('saran')
            ->with('success', 'Ulasan berhasil dihapus.');
    }

    // Kedua action berikut WAJIB berada di grup middleware auth + admin.
    public function adminIndex(Request $request)
    {
        $filter = $request->query('filter', 'semua');
        if (! in_array($filter, ['semua', 'tampil', 'sembunyi'], true)) $filter = 'semua';

        $query = Review::query()->latest();
        if ($filter !== 'semua') {
            $query->where('is_visible', $filter === 'tampil');
        }

        $reviews = $query->paginate(12)->withQueryString();
        $totalReviews = Review::count();
        $visibleReviews = Review::where('is_visible', true)->count();
        $hiddenReviews = $totalReviews - $visibleReviews;
        $averageRating = round((float) Review::avg('rating'), 1);

        return view('admin.reviews', compact(
            'reviews', 'filter', 'totalReviews', 'visibleReviews',
            'hiddenReviews', 'averageRating'
        ));
    }

    public function toggleVisibility(Review $review)
    {
        $review->update(['is_visible' => ! (bool) $review->is_visible]);

        return back()->with('success', $review->is_visible
            ? 'Ulasan kembali ditampilkan di beranda.'
            : 'Ulasan berhasil disembunyikan dari beranda.');
    }

    public function destroyByAdmin(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
