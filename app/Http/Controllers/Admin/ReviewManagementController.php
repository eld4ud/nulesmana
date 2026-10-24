<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewManagementController extends Controller
{
    /**
     * Menampilkan halaman kelola ulasan.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');

        if (! in_array($status, ['all', 'visible', 'hidden'], true)) {
            $status = 'all';
        }

        $search = trim((string) $request->query('search', ''));
        $search = mb_substr($search, 0, 100);

        // Statistik dari seluruh ulasan.
        $totalReviews = Review::query()->count();

        $visibleReviews = Review::query()
            ->where('is_visible', true)
            ->count();

        $hiddenReviews = Review::query()
            ->where('is_visible', false)
            ->count();

        $averageRating = (float) (
            Review::query()->avg('rating') ?? 0
        );

        // Data ulasan untuk tabel admin.
        $query = Review::query()->latest();

        if ($status === 'visible') {
            $query->where('is_visible', true);
        }

        if ($status === 'hidden') {
            $query->where('is_visible', false);
        }

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('message', 'like', '%' . $search . '%');
            });
        }

        $reviews = $query
            ->paginate(10)
            ->withQueryString();

        return view('admin.reviews', compact(
            'reviews',
            'totalReviews',
            'visibleReviews',
            'hiddenReviews',
            'averageRating',
            'status',
            'search'
        ));
    }

    /**
     * Sembunyikan atau tampilkan kembali ulasan.
     */
    public function toggleVisibility(Review $review): RedirectResponse
    {
        $review->is_visible = ! (bool) $review->is_visible;
        $review->save();

        $message = $review->is_visible
            ? 'Ulasan berhasil ditampilkan kembali.'
            : 'Ulasan berhasil disembunyikan dari website publik.';

        return back()->with('success', $message);
    }

    /**
     * Hapus ulasan secara permanen.
     */
    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with(
            'success',
            'Ulasan berhasil dihapus secara permanen.'
        );
    }
}
