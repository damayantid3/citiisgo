@extends('layouts.App')

@section('title', 'Penginapan')

@section('content')

<div class="content">

    <!-- Header -->
    <div class="page-header">

        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">

            <div>

                <h1>Kelola Penginapan</h1>

                <p>
                    Kelola seluruh data penginapan yang tersedia pada wisata Anda
                </p>

            </div>

            <button class="btn btn-primary">
                + Tambah Penginapan
            </button>

        </div>

    </div>

    <!-- Statistik -->
    <div class="stats-grid">

        <div class="stat-card" style="--accent:var(--green-600)">

            <div class="stat-label">
                Total Penginapan
            </div>

            <div class="stat-value">
                7
            </div>

            <div class="stat-trend trend-up">
                Unit Aktif
            </div>

        </div>

        <div class="stat-card" style="--accent:var(--orange-500)">

            <div class="stat-label">
                Total Kamar
            </div>

            <div class="stat-value">
                42
            </div>

            <div class="stat-trend trend-up">
                Tersedia
            </div>

        </div>

        <div class="stat-card" style="--accent:#1565C0">

            <div class="stat-label">
                Booking Bulan Ini
            </div>

            <div class="stat-value">
                128
            </div>

            <div class="stat-trend trend-up">
                +18%
            </div>

        </div>

        <div class="stat-card" style="--accent:#6A1B9A">

            <div class="stat-label">
                Pendapatan
            </div>

            <div class="stat-value">
                Rp 14,7jt
            </div>

            <div class="stat-trend trend-up">
                Bulan Ini
            </div>

        </div>

    </div>

    <!-- Filter -->
    <div class="card" style="margin-bottom:20px;">

        <div style="display:flex;gap:12px;flex-wrap:wrap;">

            <input
                type="text"
                placeholder="Cari penginapan..."
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

            <span>Daftar Penginapan</span>

            <button class="btn btn-outline btn-sm">
                Export Data
            </button>

        </div>

        <div class="table-wrap">

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Nama Penginapan</th>
                        <th>Jumlah Kamar</th>
                        <th>Harga/Malam</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>

                        <td>Villa Curug Indah</td>

                        <td>10</td>

                        <td>Rp 350.000</td>

                        <td>Tasikmalaya</td>

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

                        <td>Cottage Sindangkerta</td>

                        <td>8</td>

                        <td>Rp 450.000</td>

                        <td>Cipatujah</td>

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

                        <td>Camping Cabin</td>

                        <td>6</td>

                        <td>Rp 250.000</td>

                        <td>Bukit Teletubbies</td>

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

                        <td>Guest House Situ Gede</td>

                        <td>5</td>

                        <td>Rp 200.000</td>

                        <td>Tasikmalaya</td>

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