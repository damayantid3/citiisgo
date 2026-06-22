@extends('layouts.app')
@section('title', 'Manajemen Reservasi - Pengelola Citiis')
@section('topbar-title', '🎫 Reservasi & Check-In')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-[10px] text-slate-400 mb-5 font-semibold">
    <span class="text-[9px]">🏠</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Operasional Lapangan</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Daftar Reservasi Tiket</span>
</div>

{{-- ── PAGE HEADER ── --}}
<div class="mb-6 w-full text-left">
    <h1 class="text-base font-extrabold tracking-tight text-slate-800">Validasi Kunjungan Wisatawan</h1>
    <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Pantau pesanan tiket masuk, jumlah rombongan, status pembayaran, serta lakukan validasi check-in real-time.</p>
</div>

{{-- ── TABLE CONTAINER CARD ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-3xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[9px]">
                    <th class="px-6 py-3.5">Kode Booking</th>
                    <th class="px-6 py-3.5">Tanggal Kunjungan</th>
                    <th class="px-6 py-3.5 text-center">Jumlah Tiket</th>
                    <th class="px-6 py-3.5">Total Bayar</th>
                    <th class="px-6 py-3.5 text-center">Status Transaksi</th>
                    <th class="px-6 py-3.5 text-center w-36">Aksi Validasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-2xs">
                @forelse($reservasi ?? [] as $resv)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-6 py-3.5 align-middle">
                        <div class="font-mono text-emerald-700 font-black text-3xs tracking-wide bg-emerald-50 border border-emerald-200/40 px-3 py-1 rounded-xl inline-block">
                            {{ $resv['kode_booking'] }}
                        </div>
                    </td>
                    <td class="px-6 py-3.5 font-black text-slate-800 tracking-tight align-middle">
                        <span class="text-[9px]">🗓️</span> {{ \Carbon\Carbon::parse($resv['tanggal_kunjungan'])->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-6 py-3.5 text-center font-black text-slate-800 tracking-tight text-2xs align-middle">{{ $resv['jumlah_tiket'] }} Orang</td>
                    <td class="px-6 py-3.5 font-black text-slate-800 tracking-tight text-2xs align-middle">Rp {{ number_format($resv['total_harga']) }}</td>
                    <td class="px-6 py-3.5 text-center align-middle">
                        @if($resv['status'] == 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-xl font-black bg-amber-50 text-amber-700 border border-amber-200/40 text-[9px] uppercase tracking-wider">Belum Bayar</span>
                        @elseif($resv['status'] == 'confirmed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-xl font-black bg-blue-50 text-blue-700 border border-blue-200/40 text-[9px] uppercase tracking-wider">Lunas (Ready)</span>
                        @elseif($resv['status'] == 'completed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-xl font-black bg-emerald-50 text-emerald-700 border border-emerald-200/40 text-[9px] uppercase tracking-wider">Sudah Check-In</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-xl font-black bg-rose-50 text-rose-700 border border-rose-200/40 text-[9px] uppercase tracking-wider">Batal</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-center align-middle">
                        @if($resv['status'] == 'confirmed')
                            <button onclick="confirmCheckIn({{ $resv['id'] }}, '{{ $resv['kode_booking'] }}')" class="bg-emerald-600 text-white font-black text-2xs px-4 h-8 rounded-xl shadow-sm hover:bg-emerald-700 active:scale-95 transition-all cursor-pointer border-none outline-none">
                                Check-In Masuk
                            </button>
                        @elseif($resv['status'] == 'pending')
                            <button onclick="confirmCheckIn({{ $resv['id'] }}, '{{ $resv['kode_booking'] }}')" class="bg-amber-500 text-white font-black text-2xs px-4 h-8 rounded-xl shadow-sm hover:bg-amber-600 active:scale-95 transition-all cursor-pointer border-none outline-none">
                                Lunasi & Masuk
                            </button>
                        @else
                            <span class="text-slate-400 font-black text-2xs uppercase tracking-wider">Selesai / Terkunci</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-bold text-2xs">
                        📭 Hari ini belum ada wisatawan yang melakukan reservasi tiket kunjungan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Hidden Form Pemicu Update Status --}}
<form id="checkInForm" method="POST" class="hidden">
    @csrf @method('PUT')
    <input type="hidden" name="status" id="statusField" value="completed">
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2300,
        customClass: { popup: 'rounded-2xl font-sans text-2xs font-black' }
    });
@endif

function confirmCheckIn(id, kode) {
    Swal.fire({
        title: 'Validasi Check-In Kunjungan?',
        text: `Apakah Anda ingin melakukan konfirmasi check-in untuk kode booking "${kode}" dan memperbolehkan rombongan masuk?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Validasi!',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded-2xl font-sans text-2xs font-bold' }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('checkInForm');
            form.action = '{{ route("pengelola.reservasi.update", ":id") }}'.replace(':id', id);
            form.submit();
        }
    });
}
</script>
@endpush