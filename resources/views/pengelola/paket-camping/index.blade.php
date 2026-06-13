@extends('layouts.App')

@section('title', 'Paket Camping')

@section('content')

<div class="content">

    <!-- Header -->
    <div class="page-header">

        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">

            <div>

                <h1>Paket Camping</h1>

                <p>
                    Kelola paket camping yang tersedia untuk wisatawan
                </p>

            </div>

            <button class="btn btn-primary">
                + Tambah Paket
            </button>

        </div>

    </div>

    <!-- Statistik -->
    <div class="stats-grid">

        <div class="stat-card" style="--accent:var(--green-600)">

            <div class="stat-label">
                Total Paket
            </div>

            <div class="stat-value">
                12
            </div>

            <div class="stat-trend trend-up">
                Paket Aktif
            </div>

        </div>

        <div class="stat-card" style="--accent:var(--orange-500)">

            <div class="stat-label">
                Booking Bulan Ini
            </div>

            <div class="stat-value">
                186
            </div>

            <div class="stat-trend trend-up">
                +15%
            </div>

        </div>

        <div class="stat-card" style="--accent:#1565C0">

            <div class="stat-label">
                Pendapatan
            </div>

            <div class="stat-value">
                Rp 8,2jt
            </div>

            <div class="stat-trend trend-up">
                Bulan Ini
            </div>

        </div>

        <div class="stat-card" style="--accent:#6A1B9A">

            <div class="stat-label">
                Rating
            </div>

            <div class="stat-value">
                4.9
            </div>

            <div class="stat-trend trend-up">
                Sangat Baik
            </div>

        </div>

    </div>

    <!-- Filter -->
    <div class="card" style="margin-bottom:20px;">

        <div style="display:flex;gap:12px;flex-wrap:wrap;">

            <input
                type="text"
                placeholder="Cari paket camping..."
                style="
                    flex:1;
                    min-width:250px;
                    padding:10px 14px;
                    border:1px solid var(--border);
                    border-radius:8px;
                    outline:none;
                "
            >

            <button class="btn btn-outline">
                Cari
            </button>

        </div>

    </div>

    <!-- Table -->
    <div class="card">

        <div class="card-title">

            <span>Daftar Paket Camping</span>

            <button class="btn btn-outline btn-sm">
                Export Data
            </button>

        </div>

        <div class="table-wrap">

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th>Kapasitas</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>

                        <td>Paket Camping Reguler</td>

                        <td>Rp 150.000</td>

                        <td>4 Orang</td>

                        <td>1 Hari</td>

                        <td>
                            <span class="badge badge-success">
                                Aktif
                            </span>
                        </td>

                        <td>

                            <div style="display:flex;gap:6px;">

                                <button class="btn btn-outline btn-sm">
                                    Detail
                                </button>

                                <button class="btn btn-outline btn-sm">
                                    Edit
                                </button>

                            </div>

                        </td>

                    </tr>

                    <tr>

                        <td>2</td>

                        <td>Paket Family Camp</td>

                        <td>Rp 350.000</td>

                        <td>8 Orang</td>

                        <td>2 Hari</td>

                        <td>
                            <span class="badge badge-success">
                                Aktif
                            </span>
                        </td>

                        <td>

                            <div style="display:flex;gap:6px;">

                                <button class="btn btn-outline btn-sm">
                                    Detail
                                </button>

                                <button class="btn btn-outline btn-sm">
                                    Edit
                                </button>

                            </div>

                        </td>

                    </tr>

                    <tr>

                        <td>3</td>

                        <td>Paket Premium Camp</td>

                        <td>Rp 750.000</td>

                        <td>10 Orang</td>

                        <td>3 Hari</td>

                        <td>
                            <span class="badge badge-warning">
                                Draft
                            </span>
                        </td>

                        <td>

                            <div style="display:flex;gap:6px;">

                                <button class="btn btn-outline btn-sm">
                                    Detail
                                </button>

                                <button class="btn btn-outline btn-sm">
                                    Edit
                                </button>

                            </div>

                        </td>

                    </tr>

                    <tr>

                        <td>4</td>

                        <td>Paket Outbound Camp</td>

                        <td>Rp 500.000</td>

                        <td>15 Orang</td>

                        <td>2 Hari</td>

                        <td>
                            <span class="badge badge-danger">
                                Nonaktif
                            </span>
                        </td>

                        <td>

                            <div style="display:flex;gap:6px;">

                                <button class="btn btn-outline btn-sm">
                                    Detail
                                </button>

                                <button class="btn btn-outline btn-sm">
                                    Edit
                                </button>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection