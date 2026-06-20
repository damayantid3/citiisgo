@extends('layouts.user')
@section('title', 'Booking Paket Camping CitiisGo')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 text-left font-sans">
    
    {{-- HEADER FORM --}}
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">🏕️ Registrasi Lapak & Paket Camping</h1>
        <p class="text-xs text-slate-500 font-medium mt-1">Rasakan sensasi bermalam di alam terbuka Citiis dengan fasilitas tenda komplit siap pakai.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
        {{-- FORM ISIAN (8 COLUMNS) --}}
        <div class="md:col-span-8 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <form action="/user/booking-camping" method="POST" class="space-y-4 m-0">
                @csrf
                <input type="hidden" name="wisata_id" value="{{ request('wisata', 1) }}">

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Pilih Paket Kemah</label>
                    <select name="paket_camping_id" id="paketSelect" onchange="hitungCamping()" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 outline-none focus:border-emerald-500 bg-white">
                        <option value="1" data-harga="120000">⛺ Paket Hemat Berdua (Tenda Dome + Matras) — Rp120.000</option>
                        <option value="2" data-harga="250000">🔥 Paket Family Bahagia (Tenda Besar + Alat Masak + Kayu Bakar) — Rp250.000</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Tanggal Check-In</label>
                        <input type="date" name="tanggal_mulai" id="tglMulai" min="{{ date('Y-m-d') }}" required onchange="hitungCamping()" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 outline-none">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Durasi Berkemah</label>
                        <select name="durasi" id="durasiSelect" onchange="hitungCamping()" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 outline-none bg-white">
                            <option value="1">1 Malam</option>
                            <option value="2">2 Malam</option>
                            <option value="3">3 Malam</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Jumlah Tenda / Lapak</label>
                    <input type="number" name="jumlah_tenda" id="qtyTenda" value="1" min="1" max="5" onchange="hitungCamping()" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 outline-none">
                </div>

                <hr class="border-slate-100 my-4">

                <button type="submit" class="w-full bg-emerald-600 text-white font-black text-xs h-11 rounded-xl shadow-md hover:bg-emerald-700 active:scale-98 transition-all cursor-pointer">
                    ⛺ Amankan Slot Lapak Kemah
                </button>
            </form>
        </div>

        {{-- RINGKASAN HARGA CAMPING (4 COLUMNS) --}}
        <div class="md:col-span-4 bg-slate-50 border border-slate-200/80 rounded-2xl p-4 sticky top-6">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">📋 Detail Sewa</h3>
            <div class="space-y-2 text-xs font-medium text-slate-500 text-left">
                <div class="flex justify-between">
                    <span>Sewa Paket Tenda</span>
                    <span class="text-slate-700 font-bold" id="cSub">Rp120.000</span>
                </div>
                <div class="flex justify-between">
                    <span>Durasi Malam</span>
                    <span class="text-slate-700 font-bold" id="cDur">1x</span>
                </div>
                <hr class="border-slate-200/60 my-2">
                <div class="flex justify-between items-baseline">
                    <span class="font-bold text-slate-800">Total Biaya</span>
                    <span class="text-base font-black text-emerald-700" id="cTotal">Rp120.000</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function hitungCamping() {
        const select = document.getElementById('paketSelect');
        const hargaSatuan = parseInt(select.options[select.selectedIndex].getAttribute('data-harga'));
        const durasi = parseInt(document.getElementById('durasiSelect').value);
        const qty = parseInt(document.getElementById('qtyTenda').value) || 1;

        const total = hargaSatuan * durasi * qty;
        const formattedSub = 'Rp' + (hargaSatuan * qty).toLocaleString('id-ID');
        const formattedTotal = 'Rp' + total.toLocaleString('id-ID');

        document.getElementById('cSub').innerText = formattedSub;
        document.getElementById('cDur').innerText = durasi + ' Malam';
        document.getElementById('cTotal').innerText = formattedTotal;
    }
</script>
@endsection