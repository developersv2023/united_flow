@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span
                class="flex items-center gap-2 px-5 py-3 rounded-2xl bg-slate-50 text-slate-300 text-[10px] font-black uppercase tracking-widest cursor-not-allowed">
                <span class="material-symbols-outlined text-[16px]">chevron_left</span> Anterior
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="flex items-center gap-2 px-5 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[16px]">chevron_left</span> Anterior
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="hidden md:flex gap-2 bg-slate-50 p-1.5 rounded-2xl border border-slate-100">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span
                        class="flex items-center justify-center size-10 rounded-xl text-slate-400 text-sm font-black">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="flex items-center justify-center size-10 rounded-xl bg-primary text-white text-sm font-black shadow-lg shadow-primary/30"
                                aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="flex items-center justify-center size-10 rounded-xl bg-transparent text-slate-500 text-sm font-black hover:bg-white hover:text-slate-900 transition-all custom-shadow-hover"
                                aria-label="Ir a página {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="flex items-center gap-2 px-5 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-colors shadow-sm">
                Siguiente <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            </a>
        @else
            <span
                class="flex items-center gap-2 px-5 py-3 rounded-2xl bg-slate-50 text-slate-300 text-[10px] font-black uppercase tracking-widest cursor-not-allowed">
                Siguiente <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            </span>
        @endif
    </nav>
@endif