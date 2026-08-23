@extends('layout')

@section('meta_title', $post->seo_title ?: $post->title . ' — ' . config('app.name'))
@section('meta_description', $post->seo_description ?: $post->excerpt)
@if ($post->featured_image)
@section('og_image', Storage::disk('public')->url($post->featured_image))
@endif

@section('content')
{{-- ── Single News / Event entry ── --}}

<section class="relative bg-[#2D2B8F] py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-[#2D2B8F] to-[#1a1950]"></div>
    <div class="absolute inset-0 opacity-[0.025]"
         style="background-image: linear-gradient(rgba(255,255,255,0.8) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.8) 1px, transparent 1px); background-size: 56px 56px;"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-white/40 mb-6">
            <a href="/" class="hover:text-white/70 transition-colors">Home</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="/news" class="hover:text-white/70 transition-colors">News &amp; Events</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/60 truncate max-w-[160px]">{{ $post->title }}</span>
        </nav>

        <div class="flex items-center gap-3 mb-5">
            @if ($post->type === 'event')
            <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full text-white" style="background-color:#CC1F1F;">Event</span>
            @else
            <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full bg-[#F5C518] text-zinc-900">News</span>
            @endif
            <time class="text-white/50 text-sm">{{ $post->published_at->format('j F Y') }}</time>
        </div>

        <h1 class="font-['Raleway'] text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">{{ $post->title }}</h1>

        @if ($post->type === 'event' && $post->event_date)
        <div class="flex flex-wrap gap-5 text-sm text-white/60">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-[#F5C518]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $post->event_date->format('l, j F Y') }}
            </span>
            @if ($post->event_location)
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-[#F5C518]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $post->event_location }}
            </span>
            @endif
        </div>
        @endif
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 32" xmlns="http://www.w3.org/2000/svg" class="w-full block">
            <path d="M0 20C480 40 960 0 1440 20V32H0V20Z" fill="white"/>
        </svg>
    </div>
</section>

{{-- Featured image --}}
@if ($post->featured_image)
<div class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10">
        <div class="rounded-3xl overflow-hidden shadow-xl aspect-video">
            <img src="{{ Storage::disk('public')->url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover" />
        </div>
    </div>
</div>
@endif

{{-- Article body --}}
<section class="bg-white py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-zinc prose-lg max-w-none
                    prose-headings:font-['Raleway'] prose-headings:font-bold prose-headings:text-zinc-900
                    prose-a:text-[#2D2B8F] prose-a:no-underline hover:prose-a:underline
                    prose-strong:text-zinc-900">
            {!! Str::markdown($post->content ?? '') !!}
        </div>

        {{-- Back link --}}
        <div class="mt-14 pt-8 border-t border-zinc-100">
            <a href="/news" class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-[#2D2B8F] transition-colors">
                <svg class="w-4 h-4 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                Back to News &amp; Events
            </a>
        </div>
    </div>
</section>

{{-- More articles --}}
<section class="bg-zinc-50 py-16 border-t border-zinc-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-['Raleway'] text-xl font-bold text-zinc-900 mb-8">More from FMKS</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            @foreach ($related as $item)
            <a href="{{ route('news.show', $item) }}" class="group bg-white border border-zinc-100 rounded-2xl p-5 hover:border-[#2D2B8F]/30 hover:-translate-y-0.5 transition-all duration-300 flex flex-col gap-3">
                <div class="flex items-center gap-2">
                    @if ($item->type === 'event')
                    <span class="text-[9px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full text-white" style="background-color:#CC1F1F;">Event</span>
                    @else
                    <span class="text-[9px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full bg-[#2D2B8F] text-white">News</span>
                    @endif
                    <time class="text-zinc-400 text-xs">{{ $item->published_at->format('j M Y') }}</time>
                </div>
                <p class="font-['Raleway'] font-bold text-zinc-900 text-sm leading-snug group-hover:text-[#2D2B8F] transition-colors">{{ Str::limit($item->title, 80) }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
