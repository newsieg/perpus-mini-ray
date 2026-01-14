@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalBooks }}</h3>
                <p>Total Buku (Jenis)</p>
            </div>
            <div class="icon"><i class="fas fa-book"></i></div>
            <a href="/admin/books" class="small-box-footer">Kelola Buku <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $activeBorrowings }}</h3>
                <p>Peminjaman Aktif</p>
            </div>
            <div class="icon"><i class="fas fa-hand-holding"></i></div>
            <a href="/admin/borrowings" class="small-box-footer">Lihat Peminjaman <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $historyCount }}</h3>
                <p>Riwayat Peminjaman</p>
            </div>
            <div class="icon"><i class="fas fa-history"></i></div>
            <a href="/admin/borrowings/history" class="small-box-footer">Lihat Riwayat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Grafik Peminjaman</h3>
        <div class="card-tools">
            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-outline-primary interval-btn active" data-interval="day">Per Hari</button>
                <button class="btn btn-sm btn-outline-primary interval-btn" data-interval="week">Per Minggu</button>
                <button class="btn btn-sm btn-outline-primary interval-btn" data-interval="month">Per Bulan</button>
                <button class="btn btn-sm btn-outline-primary interval-btn" data-interval="year">Per Tahun</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <canvas id="borrowingsChart" style="height:300px"></canvas>
    </div>
</div>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.umd.min.js"></script>
<script>
    let chart = null;
    function fetchAndRender(interval = 'day') {
        fetch(`/admin/dashboard/data?interval=${interval}`)
            .then(res => res.json())
            .then(payload => {
                const ctx = document.getElementById('borrowingsChart').getContext('2d');
                if (chart) chart.destroy();
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: payload.labels,
                        datasets: [{
                            label: 'Peminjaman',
                            data: payload.data,
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0,123,255,0.1)',
                            tension: 0.3,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetchAndRender('day');
        document.querySelectorAll('.interval-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.interval-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                fetchAndRender(this.getAttribute('data-interval'));
            });
        });
    });
</script>
@endsection

@endsection
