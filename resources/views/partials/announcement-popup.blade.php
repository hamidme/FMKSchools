@if ($announcement)
<div
    x-data="announcementPopup({{ $announcement->id }})"
    x-init="init()"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4"
>
    {{-- Backdrop --}}
    <div @click="dismiss()" class="absolute inset-0 bg-zinc-900/60 backdrop-blur-sm"></div>

    {{-- Modal --}}
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden"
    >
        <div class="h-1.5 w-full bg-gradient-to-r from-[#2D2B8F] via-[#F5C518] to-[#CC1F1F]"></div>

        <button
            @click="dismiss()"
            aria-label="Close"
            class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white/90 hover:bg-white flex items-center justify-center text-zinc-500 hover:text-zinc-900 shadow-sm transition-colors"
        >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        @if ($announcement->image)
        <div class="aspect-video overflow-hidden">
            <img src="{{ Storage::disk('public')->url($announcement->image) }}" alt="{{ $announcement->title }}" class="w-full h-full object-cover" />
        </div>
        @endif

        <div class="p-8">
            <span class="text-[#F5C518] text-xs font-bold uppercase tracking-widest mb-3 block">Announcement</span>
            <h2 class="font-['Raleway'] text-2xl font-bold text-zinc-900 mb-3">{{ $announcement->title }}</h2>
            <p class="text-zinc-600 leading-relaxed mb-6">{{ $announcement->message }}</p>

            @if ($announcement->link_url && $announcement->link_text)
            <a
                href="{{ $announcement->link_url }}"
                class="inline-flex items-center gap-2 bg-[#2D2B8F] text-white font-bold px-6 py-3 rounded-full hover:bg-[#1a1950] transition-colors"
            >
                {{ $announcement->link_text }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            @endif
        </div>
    </div>
</div>
@endif
