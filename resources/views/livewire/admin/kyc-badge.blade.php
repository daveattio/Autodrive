<div wire:poll.10s class="inline-flex items-center justify-center ml-auto">
    @if($count > 0)
        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-purple-600 text-[12px] font-bold text-white shadow-sm animate-pulse ring-2 ring-purple-100">
            {{ $count }}
        </span>
    @endif
</div>
