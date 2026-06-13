@extends('layouts.App'')

@section('title', 'Laporan')

@section('content')

<div class="content">

    <!-- Header -->
    <div class="page-header">

        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">

            <div>

                <h1>Laporan Pengelola</h1>

                <p>
                    Statistik kunjungan, reservasi dan pendapatan wisata
                </p>

            </div>

            <div style="display:flex;gap:10px;">

                <button class="btn btn-outline">
                    Export Excel
                </button>

                <button class="btn btn-primary">
                    Export PDF
                </button>

            </div>

        </div>

    </div>

    <!-- Statistik -->
    <div class="stats-grid">

        <div class="stat-card" style="--accent:var(--green-600)">

            <div class="stat-label">
                Total Kunjungan
            </div>

            <div class="stat-value">
                12.845
            </div>

            <div class="stat-trend trend-up">
                +18.4%
            </div>

        </div>

        <div class="stat-card" style="--accent:var(--orange-500)">

            <div class="stat-label">
                Total Reservasi
            </div>

            <div class="stat-value">
                2.347
            </div>

            <div class="stat-trend trend-up">
                +12.7%
            </div>

        </div>

        <div class="stat-card" style="--accent:#1565C0">

            <div class="stat-label">
                Pendapatan
            </div>

            <div class="stat-value">
                Rp 48,2jt
            </div>

            <div class="stat-trend trend-up">
                +22.5%
            </div>

        </div>

        <div class="stat-card" style="--accent:#6A1B9A">

            <div class="stat-label">
                Tingkat Hunian
            </div>

            <div class="stat-value">
                86%
            </div>

            <div class="stat-trend trend-up">
                Penginapan
            </div>

        </div>

    </div>

    <!-- Grafik -->
    <div class="grid-2">

        <div class="card">

            <div class="card-title">
                Pendapatan Bulanan
            </div>

            <div class="chart-bars" id="laporanChart"></div>

            <div
                style="display:flex;gap:0;margin-top:10px"
                id="laporanLabels"
            ></div>

        </div>

        <div class="card">

            <div class="card-title">
                Ringkasan Statistik
            </div>

            <div style="display:flex;flex-direction:column;gap:16px;">

                <div>

                    <strong>Kunjungan Wisata</strong>

                    <div
                        style="
                            background:#E8F5E9;
                            height:10px;
                            border-radius:20px;
                            margin-top:6px;
                        "
                    >
                        <div
                            style="
                                width:85%;
                                height:10px;
                                background:#2E7D32;
                                border-radius:20px;
                            "
                        ></div>
                    </div>

                </div>

                <div>

                    <strong>Reservasi</strong>

                    <div
                        style="
                            background:#FFF3E0;
                            height:10px;
                            border-radius:20px;
                            margin-top:6px;
                        "
                    >
                        <div
                            style="
                                width:72%;
                                height:10px;
                                background:#F47A20;
                                border-radius:20px;
                            "
                        ></div>
                    </div>

                </div>

                <div>

                    <strong>Penginapan</strong>

                    <div
                        style="
                            background:#E3F2FD;
                            height:10px;
                            border-radius:20px;
                            margin-top:6px;
                        "
                    >
                        <div
                            style="
                                width:60%;
                                height:10px;
                                background:#1565C0;
                                border-radius:20px;
                            "
                        ></div>
                    </div>

                </div>

                <div>

                    <strong>Sewa Peralatan</strong>

                    <div
                        style="
                            background:#F3E5F5;
                            height:10px;
                            border-radius:20px;
                            margin-top:6px;
                        "
                    >
                        <div
                            style="
                                width:50%;
                                height:10px;
                                background:#6A1B9A;
                                border-radius:20px;
                            "
                        ></div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Tabel -->
    <div class="card">

        <div class="card-title">
            Laporan Kunjungan Wisata
        </div>

        <div class="table-wrap">

            <table>

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Nama Wisata</th>
                        <th>Kunjungan</th>
                        <th>Reservasi</th>
                        <th>Pendapatan</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>

                        <td>Curug Cimedang</td>

                        <td>4.258</td>

                        <td>845</td>

                        <td>Rp 15.400.000</td>

                        <td>
                            <span class="badge badge-success">
                                Aktif
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>2</td>

                        <td>Bukit Teletubbies</td>

                        <td>3.712</td>

                        <td>628</td>

                        <td>Rp 12.200.000</td>

                        <td>
                            <span class="badge badge-success">
                                Aktif
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>3</td>

                        <td>Situ Gede</td>

                        <td>2.647</td>

                        <td>481</td>

                        <td>Rp 9.850.000</td>

                        <td>
                            <span class="badge badge-success">
                                Aktif
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>4</td>

                        <td>Pantai Sindangkerta</td>

                        <td>2.228</td>

                        <td>393</td>

                        <td>Rp 8.650.000</td>

                        <td>
                            <span class="badge badge-success">
                                Aktif
                            </span>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

const months = ['Jan','Feb','Mar','Apr','Mei','Jun'];

const values = [12,18,22,26,31,48];

const chart = document.getElementById('laporanChart');

const labels = document.getElementById('laporanLabels');

const max = Math.max(...values);

values.forEach((value,index)=>{

    const group = document.createElement('div');

    group.className='bar-group';

    const bar = document.createElement('div');

    bar.className='bar';

    bar.style.height=(value/max*100)+'%';

    bar.style.background='var(--green-500)';

    group.appendChild(bar);

    chart.appendChild(group);

    const label=document.createElement('div');

    label.style.cssText='flex:1;text-align:center;font-size:10px;color:var(--text-muted)';

    label.innerHTML=months[index];

    labels.appendChild(label);

});

</script>

@endsection