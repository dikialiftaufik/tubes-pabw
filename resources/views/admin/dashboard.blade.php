@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    {{-- Baris untuk Small Box --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            {{-- Kartu untuk Total Pendapatan --}}
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp {{ number_format($statistik['totalPendapatan'], 0, ',', '.') }}</h3>
                    <p>Total Pendapatan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="#" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            {{-- Kartu untuk Total Pesanan --}}
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $statistik['totalPesanan'] }}</h3>
                    <p>Total Pesanan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <a href="#" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
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
                    <i class="fas fa-calendar-check"></i>
                </div>
                <a href="#" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
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
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="#" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    {{-- Baris untuk Grafik --}}
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line"></i> Grafik Pendapatan (7 Hari Terakhir)</h3>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie"></i> Menu Terlaris (Minggu Ini)</h3>
                </div>
                <div class="card-body">
                    <canvas id="topMenusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    $(function () {
        // --- SCRIPT UNTUK GRAFIK PENDAPATAN (TETAP SAMA) ---
        const revenueLabels = @json($labelsPendapatan);
        const revenueData = @json($dataPendapatan);

        var revenueChartCanvas = $('#revenueChart').get(0).getContext('2d');
        var revenueChartData = {
            labels: revenueLabels,
            datasets: [{
                label: 'Pendapatan',
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                borderColor: 'rgba(40, 167, 69, 1)',
                pointRadius: 5,
                pointColor: '#28a745',
                pointStrokeColor: 'rgba(40, 167, 69, 1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(40, 167, 69, 1)',
                data: revenueData
            }]
        };

        var revenueChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: { display: false },
            scales: {
                xAxes: [{ gridLines: { display: false } }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
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

        new Chart(revenueChartCanvas, {
            type: 'line',
            data: revenueChartData,
            options: revenueChartOptions
        });

        // --- SCRIPT BARU UNTUK GRAFIK MENU TERLARIS (PIE CHART) ---
        const topMenusLabels = @json($menuTerlaris['labels']);
        const topMenusData = @json($menuTerlaris['data']);

        var topMenusChartCanvas = $('#topMenusChart').get(0).getContext('2d');
        var topMenusChartData = {
            labels: topMenusLabels,
            datasets: [{
                data: topMenusData,
                backgroundColor: ['#d9534f', '#5cb85c', '#f0ad4e', '#5bc0de', '#337ab7'],
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

        new Chart(topMenusChartCanvas, {
            type: 'pie', // Mengubah tipe grafik menjadi 'pie'
            data: topMenusChartData,
            options: topMenusChartOptions
        });
    });
</script>
@endpush

