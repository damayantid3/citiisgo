@extends('layouts.App')

@section('title', 'Peralatan Camping')

@section('content')

<div class="content">

    <!-- Header -->
    <div class="page-header">

        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">

            <div>

                <h1>Kelola Peralatan</h1>

                <p>
                    Kelola seluruh peralatan yang dapat disewakan kepada wisatawan
                </p>

            </div>

            <button class="btn btn-primary">
                + Tambah Peralatan
            </button>

        </div>

    </div>

    <!-- Statistik -->
    <div class="stats-grid">

        <div class="stat-card" style="--accent:var(--green-600)">

            <div class="stat-label">
                Total Item
            </div>

            <div class="stat-value">
                126
            </div>

            <div class="stat-trend trend-up">
                Peralatan Aktif
            </div>

        </div>

        <div class="stat-card" style="--accent:var(--orange-500)">

            <div class="stat-label">
                Disewa Hari Ini
            </div>

            <div class="stat-value">
                37
            </div>

            <div class="stat-trend trend-up">
                +8%
            </div>

        </div>

        <div class="stat-card" style="--accent:#1565C0">

            <div class="stat-label">
                Pendapatan Sewa
            </div>

            <div class="stat-value">
                Rp 3,8jt
            </div>

            <div class="stat-trend trend-up">
                Bulan Ini
            </div>

        </div>

        <div class="stat-card" style="--accent:#6A1B9A">

            <div class="stat-label">
                Stok Menipis
            </div>

            <div class="stat-value">
                6
            </div>

            <div class="stat-trend trend-down">
                Perlu Restock
            </div>

        </div>

    </div>

    <!-- Filter -->
    <div class="card" style="margin-bottom:20px;">

        <div style="display:flex;gap:12px;flex-wrap:wrap;">

            <input
                type="text"
                placeholder="Cari peralatan..."
                style="
                    flex:1;
                    min-width:250px;
                    padding:10px 14px;
                    border:1px solid var(--border);
                    border-radius:8px;
                    outline:none;
                "
            >

            <select
                style="
                    padding:10px 14px;
                    border:1px solid var(--border);
                    border-radius:8px;
                "
            >
                <option>Semua Kategori</option>
                <option>Tenda</option>
                <option>Sleeping Bag</option>
                <option>Kompor</option>
                <option>Lampu</option>
            </select>

            <button class="btn btn-outline">
                Cari
            </button>

        </div>

    </div>

    <!-- Table -->
    <div class="card">

        <div class="card-title">

            <span>Daftar Peralatan</span>

            <button class="btn btn-outline btn-sm">
                Export Data
            </button>

        </div>

        <div class="table-wrap">

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Nama Peralatan</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga Sewa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>

                        <td>Tenda Kapasitas 4 Orang</td>

                        <td>Tenda</td>

                        <td>15</td>

                        <td>Rp 50.000 / Hari</td>

                        <td>
                            <span class="badge badge-success">
                                Tersedia
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

                        <td>Sleeping Bag Premium</td>

                        <td>Sleeping Bag</td>

                        <td>24</td>

                        <td>Rp 15.000 / Hari</td>

                        <td>
                            <span class="badge badge-success">
                                Tersedia
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

                        <td>Kompor Portable</td>

                        <td>Kompor</td>

                        <td>7</td>

                        <td>Rp 20.000 / Hari</td>

                        <td>
                            <span class="badge badge-warning">
                                Stok Menipis
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

                        <td>Lampu Camping LED</td>

                        <td>Lampu</td>

                        <td>0</td>

                        <td>Rp 10.000 / Hari</td>

                        <td>
                            <span class="badge badge-danger">
                                Habis
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