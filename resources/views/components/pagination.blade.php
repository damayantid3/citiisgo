{{-- resources/views/components/pagination.blade.php --}}
@if(isset($pagination) && isset($pagination['last_page']) && $pagination['last_page'] > 1)
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        {{-- Info total data --}}
        <span class="text-xs text-slate-400 font-medium">
            Menampilkan halaman <strong>{{ $pagination['current_page'] }}</strong> dari <strong>{{ $pagination['last_page'] }}</strong> (Total: <strong>{{ $pagination['total'] }}</strong> data)
        </span>
        
        {{-- Navigasi Tombol --}}
        <div class="inline-flex items-center gap-1">
            {{-- Tombol Sebelum --}}
            @if($pagination['current_page'] == 1)
                <button class="w-8 h-8 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs font-bold text-slate-300 cursor-not-allowed shadow-sm" disabled>‹</button>
            @else
                <a href="{{ request()->fullUrlWithQuery([($paramName ?? 'page') => $pagination['current_page'] - 1]) }}" 
                   class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 flex items-center justify-center text-xs font-bold text-slate-600 shadow-sm active:scale-95 transition-transform text-center decoration-none">
                    ‹
                </a>
            @endif

            {{-- Indikator Halaman Tengah --}}
            <span class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shadow-sm shadow-emerald-600/10">
                {{ $pagination['current_page'] }}
            </span>

            {{-- Tombol Sesudah --}}
            @if($pagination['current_page'] == $pagination['last_page'])
                <button class="w-8 h-8 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs font-bold text-slate-300 cursor-not-allowed shadow-sm" disabled>›</button>
            @else
                <a href="{{ request()->fullUrlWithQuery([($paramName ?? 'page') => $pagination['current_page'] + 1]) }}" 
                   class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 flex items-center justify-center text-xs font-bold text-slate-600 shadow-sm active:scale-95 transition-transform text-center decoration-none">
                    ›
                </a>
            @endif
        </div>
    </div>
@endif