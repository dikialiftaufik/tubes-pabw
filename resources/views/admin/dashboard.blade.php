@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard Monitoring</h1>
@stop

@section('content')
    {{-- Baris untuk Small Box --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            {{-- Kartu untuk Total Pendapatan --}}
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp {{ number_format($statistik['totalPendapatan'], 0, ',', '.') }}</h3>
                    <p>Total Pendapatan (Selesai)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            {{-- Kartu untuk Total Pesanan --}}
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $statistik['totalPesanan'] }}</h3>
                    <p>Total Transaksi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-basket"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            {{-- Kartu untuk Total Reservasi --}}
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $statistik['totalReservasi'] }}</h3>
                    <p>Total Reservasi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            {{-- Kartu untuk Pelanggan Baru --}}
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $statistik['pelangganBaru'] }}</h3>
                    <p>Pelanggan Baru (Bulan Ini)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Baris untuk Grafik --}}
    <div class="row">
        {{-- Grafik Line: Pendapatan --}}
        <div class="col-lg-7">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i> Grafik Pendapatan (7 Hari Terakhir)</h3>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik Pie: Menu Terlaris --}}
        <div class="col-lg-5">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Top 5 Menu Terlaris</h3>
                </div>
                <div class="card-body">
                    <canvas id="topMenusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function () {
        // --- 1. CONFIG LINE CHART (PENDAPATAN) ---
        const revenueLabels = @json($labelsPendapatan);
        const revenueData = @json($dataPendapatan);

        var revenueChartCanvas = $('#revenueChart').get(0).getContext('2d');
        var revenueChartData = {
            labels: revenueLabels,
            datasets: [{
                label: 'Pendapatan',
                backgroundColor: 'rgba(60, 141, 188, 0.1)',
                borderColor: 'rgba(60, 141, 188, 0.8)',
                pointRadius: 4,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: revenueData,
                fill: true
            }]
        };

        var revenueChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: { display: false },
            scales: {
                xAxes: [{ gridLines: { display: false } }],
                yAxes: [{
                    gridLines: { display: true },
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return ' Pendapatan: Rp ' + new Intl.NumberFormat('id-ID').format(tooltipItem.yLabel);
                    }
                }
            }
        };

        // Render Line Chart
        new Chart(revenueChartCanvas, {
            type: 'line',
            data: revenueChartData,
            options: revenueChartOptions
        });

        // --- 2. CONFIG PIE CHART (MENU TERLARIS) ---
        const topMenusLabels = @json($menuTerlaris['labels']);
        const topMenusData = @json($menuTerlaris['data']);

        // Cek jika data kosong agar chart tidak error
        if(topMenusData.length === 0) {
            topMenusLabels.push('Belum ada data');
            topMenusData.push(1);
        }

        var topMenusChartCanvas = $('#topMenusChart').get(0).getContext('2d');
        var topMenusChartData = {
            labels: topMenusLabels,
            datasets: [{
                data: topMenusData,
                backgroundColor: [
                    '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'
                ],
            }]
        };

        var topMenusChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                position: 'right',
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce(function(previousValue, currentValue) {
                            return previousValue + currentValue;
                        });
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                        return ' ' + data.labels[tooltipItem.index] + ': ' + currentValue + ' porsi (' + percentage + '%)';
                    }
                }
            }
        };

        // Render Pie Chart
        new Chart(topMenusChartCanvas, {
            type: 'doughnut', // Menggunakan Doughnut agar lebih modern, ganti 'pie' jika ingin full
            data: topMenusChartData,
            options: topMenusChartOptions
        });
    });
</script>
@stop