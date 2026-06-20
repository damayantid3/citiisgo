@extends('layouts.app')
@section('title', 'Manajemen Reservasi - Pengelola Citiis')
@section('topbar-title', '🎫 Reservasi & Check-In')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <span class="text-sm">🎫</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Operasional Lapangan</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Daftar Reservasi Tiket</span>
</div>

{{-- ── PAGE HEADER ── --}}
<div class="mb-6 w-full text-left">
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">🎫 Validasi Kunjungan Wisatawan</h1>
    <p class="text-sm text-slate-500 font-medium mt-1">Pantau pesanan tiket masuk, jumlah rombongan, status pembayaran, serta lakukan validasi check-in real-time.</p>
</div>

{{-- ── TABLE CONTAINER CARD ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="px-5 py-4">Kode Booking</th>
                    <th class="px-5 py-4">Tanggal Kunjungan</th>
                    <th class="px-5 py-4 text-center">Jumlah Tiket</th>
                    <th class="px-5 py-4">Total Bayar</th>
                    <th class="px-5 py-4 text-center">Status Transaksi</th>
                    <th class="px-5 py-4 text-center w-36">Aksi Validasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($reservasi ?? [] as $resv)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="font-mono text-emerald-700 font-bold text-sm tracking-wide bg-emerald-50 border border-emerald-200/40 px-2 py-0.5 rounded-lg inline-block">
                            {{ $resv['kode_booking'] }}
                        </div>
                    </td>
                    <td class="px-5 py-3.5 font-bold text-slate-800">
                        🗓️ {{ \Carbon\Carbon::parse($resv['tanggal_kunjungan'])->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-5 py-3.5 text-center font-extrabold text-slate-900 text-sm">{{ $resv['jumlah_tiket'] }} Orang</td>
                    <td class="px-5 py-3.5 font-bold text-slate-900">Rp {{ number_format($resv['total_harga']) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        @if($resv['status'] == 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-bold bg-amber-50 text-amber-700 border border-amber-200/40 text-[10px] uppercase">⏳ Belum Bayar</span>
                        @elseif($resv['status'] == 'confirmed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-bold bg-blue-50 text-blue-700 border border-blue-200/40 text-[10px] uppercase">✅ Lunas (Ready)</span>
                        @elseif($resv['status'] == 'completed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/40 text-[10px] uppercase">🏁 Sudah Check-In</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-bold bg-rose-50 text-rose-700 border border-rose-200/40 text-[10px] uppercase">✕ Batal</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        @if($resv['status'] == 'confirmed')
                            <button onclick="confirmCheckIn({{ $resv['id'] }}, '{{ $resv['kode_booking'] }}')" class="bg-emerald-600 text-white font-bold text-[10px] px-3 py-1.5 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-transform cursor-pointer border-none outline-none">
                                🔑 Check-In Masuk
                            </button>
                        @elseif($resv['status'] == 'pending')
                            <button onclick="confirmCheckIn({{ $resv['id'] }}, '{{ $resv['kode_booking'] }}')" class="bg-amber-500 text-white font-bold text-[10px] px-3 py-1.5 rounded-xl shadow-md shadow-amber-500/10 hover:bg-amber-600 active:scale-95 transition-transform cursor-pointer border-none outline-none">
                                🪙 Lunasi & Masuk
                            </button>
                        @else
                            <span class="text-slate-400 font-bold text-[11px]">Selesai / Terkunci</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-slate-400 font-medium">📭 Hari ini belum ada wisatawan yang melakukan reservasi tiket kunjungan.</td>
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
        customClass: { popup: 'rounded-2xl font-sans text-xs' }
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
        customClass: { popup: 'rounded-2xl font-sans' }
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