<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Support\NulesmanaMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class NewsEditController extends Controller
{
    public function edit(int $id)
    {
        $news = News::findOrFail($id);

        return view('admin.news-edit', compact('news'));
    }

    public function update(Request $request, int $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:' . now('Asia/Jakarta')->toDateString()],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ], [
            'event_date.before_or_equal' => 'Tanggal berita tidak boleh melewati hari ini (WIB).',
        ]);

        $changes = [
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'content' => $validated['content'],
        ];

        $newImagePath = null;
        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('news', NulesmanaMedia::newsDisk());
            $changes['image'] = $newImagePath;
        } elseif ($request->boolean('remove_image')) {
            $changes['image'] = null;
        }

        try {
            $news->update($changes);
        } catch (Throwable $exception) {
            if ($newImagePath) {
                Storage::disk(NulesmanaMedia::newsDisk())->delete($newImagePath);
            }
            throw $exception;
        }

        // Foto lama sengaja tidak dihapus otomatis agar aman saat revisi.
        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Perubahan berita berhasil disimpan.');
    }
}
