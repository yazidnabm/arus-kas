@extends('layouts.contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')

<h4 class="fw-bold mb-1">Dashboard</h4>
<p class="text-muted mb-4">
    Selamat datang di Sistem Arus Kas Toko Snack Bu Ana
</p>

{{-- CARD RINGKASAN --}}
<div class="row mb-4">

    <div class="col-md-3">
        <div class="card border-start border-success border-3">
            <div class="card-body">
                <span class="text-muted">Saldo Kas</span>
                <h4 class="fw-bold mt-2">
                    Rp {{ number_format($saldo,0,',','.') }}
                </h4>
                <small class="text-muted">Saldo saat ini</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-start border-success border-3">
            <div class="card-body">
                <span class="text-muted">Total Kas Masuk</span>
                <h4 class="text-success fw-bold mt-2">
                    Rp {{ number_format($totalMasuk,0,',','.') }}
                </h4>
                <small class="text-muted">Bulan ini</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-start border-danger border-3">
            <div class="card-body">
                <span class="text-muted">Total Kas Keluar</span>
                <h4 class="text-danger fw-bold mt-2">
                    Rp {{ number_format($totalKeluar,0,',','.') }}
                </h4>
                <small class="text-muted">Bulan ini</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-start border-warning border-3">
            <div class="card-body">
                <span class="text-muted">Total Transaksi</span>
                <h4 class="fw-bold mt-2">{{ $totalTransaksi }}</h4>
                <small class="text-muted">Bulan ini</small>
            </div>
        </div>
    </div>

</div>

{{-- GRAFIK --}}
<div class="row">

    {{-- GRAFIK KAS MASUK --}}
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">
                    <i class="bx bx-down-arrow-circle text-success me-1"></i>
                    Grafik Kas Masuk
                </h5>

                <canvas id="chartKasMasuk" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- GRAFIK KAS KELUAR --}}
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">
                    <i class="bx bx-up-arrow-circle text-danger me-1"></i>
                    Grafik Kas Keluar
                </h5>

                <canvas id="chartKasKeluar" height="120"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Kas Masuk
    new Chart(document.getElementById('chartKasMasuk'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($kasMasukChart->pluck('tanggal')) !!},
            datasets: [{
                label: 'Kas Masuk',
                data: {!! json_encode($kasMasukChart->pluck('total')) !!},
                backgroundColor: '#28a745'
            }]
        }
    });

    // Kas Keluar
    new Chart(document.getElementById('chartKasKeluar'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($kasKeluarChart->pluck('tanggal')) !!},
            datasets: [{
                label: 'Kas Keluar',
                data: {!! json_encode($kasKeluarChart->pluck('total')) !!},
                backgroundColor: '#dc3545'
            }]
        }
    });
</script>

@endsection
