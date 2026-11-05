<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicNewsController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim((string) ($validated['search'] ?? ''));

        $query = News::query()->when($search !== '', function ($query) use ($search) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        });

        // Gunakan endpoint /news yang sama untuk saran pencarian langsung.
        if ($request->boolean('suggest')) {
            if ($search === '') {
                return response()->json(['results' => []]);
            }

            $results = (clone $query)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->limit(6)
                ->get(['id', 'title', 'event_date', 'created_at'])
                ->map(fn (News $item) => [
                    'title' => (string) $item->title,
                    'type' => $item->event_date ? 'Agenda' : 'Berita',
                    'date' => $item->created_at?->translatedFormat('d M Y') ?? '-',
                    'url' => route('public.news.show', ['id' => $item->id]),
                ])
                ->values();

            return response()->json(['results' => $results]);
        }

        // Selalu tampilkan publikasi terbaru lebih dulu.
        $newsList = $query
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(8)
            ->withQueryString();

        return view('news.index', compact('newsList', 'search'));
    }
}
