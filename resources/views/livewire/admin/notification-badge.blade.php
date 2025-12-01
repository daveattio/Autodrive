<div wire:poll.10s class="inline-block">
    @if($count > 0)
        <span class="bg-red-900 text-white text-[20px] font-bold px-2 py-0.5 rounded-full shadow-sm animate-pulse">
            {{ $count }}
        </span>
    @endif
</div>
