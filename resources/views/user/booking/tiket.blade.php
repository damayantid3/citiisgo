@extends('layouts.user')
@section('title', 'Pesan Tiket Masuk CitiisGo')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 text-left font-sans">
    
    {{-- HEADER FORM --}}
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">🎟️ Reservasi Tiket Kunjungan</h1>
        <p class="text-xs text-slate-500 font-medium mt-1">Isi form di bawah ini untuk mengamankan kuota kunjungan Anda ke Kawasan Wisata Citiis.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
        {{-- FORM ISIAN (8 COLUMNS) --}}
        <div class="md:col-span-8 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <form action="/user/reservasi" method="POST" class="space-y-4 m-0">
                @csrf
                <input type="hidden" name="wisata_id" value="{{ request('wisata', 1) }}">

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Tanggal Kedatangan</label>
                    <input type="date" name="tanggal_kunjungan" min="{{ date('Y-m-m') }}" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 outline-none focus:border-emerald-500 bg-slate-50/50">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Jumlah Tiket / Orang</label>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="setQty(-1)" class="w-8 h-8 rounded-lg border border-slate-200 font-black text-sm flex items-center justify-center bg-white hover:bg-slate-50 cursor-pointer select-none">-</button>
                        <input type="number" name="jumlah_orang" id="qtyTiket" value="1" min="1" max="20" readonly class="w-12 text-center border-none font-extrabold text-sm text-slate-800 outline-none">
                        <button type="button" onclick="setQty(1)" class="w-8 h-8 rounded-lg border border-slate-200 font-black text-sm flex items-center justify-center bg-white hover:bg-slate-50 cursor-pointer select-none">+</button>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5 pt-2">
                    <label class="text-xs font-bold text-slate-500">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" rows="3" placeholder="Contoh: Rombongan keluarga besar membawa anak kecil..." class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 resize-none"></textarea>
                </div>

                <hr class="border-slate-100 my-4">

                <button type="submit" class="w-full bg-emerald-600 text-white font-black text-xs h-11 rounded-xl shadow-md hover:bg-emerald-700 active:scale-98 transition-all cursor-pointer">
                    🚀 Lanjutkan Pembayaran Instan
                </button>
            </form>
        </div>

        {{-- RINGKASAN HARGA (4 COLUMNS) --}}
        <div class="md:col-span-4 bg-slate-50 border border-slate-200/80 rounded-2xl p-4 sticky top-6">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">💰 Rincian Biaya</h3>
            <div class="space-y-2 text-xs font-medium text-slate-500">
                <div class="flex justify-between">
                    <span>Tiket Masuk x <span id="lblQty">1</span></span>
                    <span class="text-slate-700 font-bold" id="lblSub">Rp15.000</span>
                </div>
                <div class="flex justify-between">
                    <span>Pajak & Retribusi</span>
                    <span class="text-emerald-600 font-bold">FREE</span>
                </div>
                <hr class="border-slate-200/60 my-2">
                <div class="flex justify-between items-baseline">
                    <span class="font-bold text-slate-800">Total Bayar</span>
                    <span class="text-base font-black text-emerald-700" id="lblTotal">Rp15.000</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const hargaSatuan = 15000; // Bisa di-echo dari $w['harga_tiket'] jika dinamis
    function setQty(val) {
        const input = document.getElementById('qtyTiket');
        let current = parseInt(input.value) + val;
        if(current < 1) current = 1;
        if(current > 20) current = 20;
        input.value = current;
        
        // Update Ringkasan visual
        document.getElementById('lblQty').innerText = current;
        const total = current * hargaSatuan;
        const formatted = 'Rp' + total.toLocaleString('id-ID');
        document.getElementById('lblSub').innerText = formatted;
        document.getElementById('lblTotal').innerText = formatted;
    }
</script>
@endsection