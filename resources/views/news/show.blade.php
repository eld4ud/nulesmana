@extends('layouts.public')

@section('title', $news->title . ' - Ranting NU Pasiraman Lor')

@section('content')
<article class="max-w-4xl mx-auto bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 lg:p-12 shadow-2xl border border-gray-100">

    <a href="{{ url('/news') }}" class="inline-flex items-center gap-2 text-xs font-black text-gray-900 hover:text-green-900 transition mb-6">
        <i class="ph ph-arrow-left"></i> Kembali ke semua berita
    </a>

    <div class="flex items-center gap-2 text-xs text-gray-600 font-bold mb-3">
        <i class="ph ph-calendar-blank text-base"></i>
        {{ $news->event_date
            ? \Carbon\Carbon::parse($news->event_date)->translatedFormat('d F Y')
            : ($news->created_at ? $news->created_at->translatedFormat('d F Y') : '-') }}
    </div>

    <h1 class="font-news text-2xl sm:text-4xl font-black text-gray-900 leading-snug break-words">{{ $news->title }}</h1>

    @if($news->image)
        <div class="mt-6 overflow-hidden rounded-2xl bg-green-950">
            <img src="{{ \Illuminate\Support\Facades\Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full max-h-[480px] object-cover">
        </div>
    @endif

    <div class="mt-6 text-sm sm:text-base text-gray-800 font-medium leading-relaxed whitespace-pre-line break-words">{{ $news->content }}</div>

    <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-between text-xs text-gray-600 font-semibold">
        <span><i class="ph ph-clock mr-1"></i>{{ $news->created_at ? $news->created_at->diffForHumans() : '' }}</span>
        <a href="{{ url('/') }}#berita" class="font-black text-gray-900 hover:text-green-900 transition">Berita lainnya →</a>
    </div>
</article>
@endsection