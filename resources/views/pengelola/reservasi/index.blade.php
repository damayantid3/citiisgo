@extends('layouts.App')

@section('title', 'Reservasi')

@section('content')

<div class="content">

    <!-- Header -->
    <div class="page-header">

        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">

            <div>

                <h1>Kelola Reservasi</h1>

                <p>
                    Kelola seluruh reservasi wisata, camping, penginapan dan sewa peralatan
                </p>

            </div>

            <button class="btn btn-primary">
                Export Reservasi
            </button>

        </div>

    </div>

    <!-- Statistik -->
    <div class="stats-grid">

        <div class="stat-card" style="--accent:var(--green-600)">
            <div class="stat-label">Total Reservasi</div>
            <div class="stat-value">1.247</div>
            <div class="stat-trend trend-up">Bulan Ini</div>
        </div>

        <div class="stat-card" style="--accent:var(--orange-500)">
            <div class="stat-label">Menunggu Konfirmasi</div>
            <div class="stat-value">37</div>
            <div class="stat-trend trend-down">Perlu Diproses</div>
        </div>

        <div class="stat-card" style="--accent:#1565C0">
            <div class="stat-label">Reservasi Berhasil</div>
            <div class="stat-value">1.120</div>
            <div class="stat-trend trend-up">89%</div>
        </div>

        <div class="stat-card" style="--accent:#6A1B9A">
            <div class="stat-label">Dibatalkan</div>
            <div class="stat-value">90</div>
            <div class="stat-trend trend-down">7%</div>
        </div>

    </div>

    <!-- Filter -->
    <div class="card" style="margin-bottom:20px;">

        <div style="display:flex;gap:12px;flex-wrap:wrap;">

            <input
                type="text"
                placeholder="Cari reservasi..."
                style="
                    flex:1;
                    min-width:250px;
                    padding:10px 14px;
                    border:1px solid var(--border);
                    border-radius:8px;
                "
            >

            <select
                style="
                    padding:10px 14px;
                    border:1px solid var(--border);
                    border-radius:8px;
                "
            >
                <option>Semua Status</option>
                <option>Pending</option>
                <option>Confirmed</option>
                <option>Completed</option>
                <option>Cancelled</option>
            </select>

            <button class="btn btn-outline">
                Cari
            </button>

        </div>

    </div>

    <!-- Table -->
    <div class="card">

        <div class="card-title">
            <span>Daftar Reservasi</span>
        </div>

        <div class="table-wrap">

            <table>

                <thead>

                    <tr>
                        <th>Kode</th>
                        <th>Nama Pemesan</th>
                        <th>Layanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>RSV-001</td>

                        <td>Budi Santoso</td>

                        <td>
                            <span class="badge badge-success">
                                Tiket Wisata
                            </span>
                        </td>

                        <td>02 Juni 2026</td>

                        <td>Rp 75.000</td>

                        <td>
                            <span class="badge badge-success">
                                Confirmed
                            </span>
                        </td>

                        <td>

                            <div style="display:flex;gap:6px;">

                                <button class="btn btn-outline btn-sm">
                                    Detail
                                </button>

                            </div>

                        </td>

                    </tr>

                    <tr>

                        <td>RSV-002</td>

                        <td>Siti Rahma</td>

                        <td>
                            <span class="badge badge-warning">
                                Camping
                            </span>
                        </td>

                        <td>03 Juni 2026</td>

                        <td>Rp 250.000</td>

                        <td>
                            <span class="badge badge-warning">
                                Pending
                            </span>
                        </td>

                        <td>

                            <div style="display:flex;gap:6px;">

                                <button class="btn btn-primary btn-sm">
                                    Konfirmasi
                                </button>

                                <button class="btn btn-outline btn-sm">
                                    Detail
                                </button>

                            </div>

                        </td>

                    </tr>

                    <tr>

                        <td>RSV-003</td>

                        <td>Ahmad Fauzi</td>

                        <td>
                            <span class="badge badge-info">
                                Penginapan
                            </span>
                        </td>

                        <td>04 Juni 2026</td>

                        <td>Rp 450.000</td>

                        <td>
                            <span class="badge badge-success">
                                Completed
                            </span>
                        </td>

                        <td>

                            <button class="btn btn-outline btn-sm">
                                Detail
                            </button>

                        </td>

                    </tr>

                    <tr>

                        <td>RSV-004</td>

                        <td>Dewi Kurnia</td>

                        <td>
                            <span
                                class="badge"
                                style="background:#F3E5F5;color:#6A1B9A"
                            >
                                Sewa Peralatan
                            </span>
                        </td>

                        <td>01 Juni 2026</td>

                        <td>Rp 120.000</td>

                        <td>
                            <span class="badge badge-danger">
                                Cancelled
                            </span>
                        </td>

                        <td>

                            <button class="btn btn-outline btn-sm">
                                Detail
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection