@extends('layouts.contentNavbarLayout')

@section('title', 'Dashboard')

@section('page-style')
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.9);
            --success-gradient: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            --danger-gradient: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%);
        }

        .welcome-banner {
            background: var(--success-gradient);
            border-radius: 20px;
            padding: 30px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.2);
        }

        .welcome-banner i.bg-icon {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 150px;
            opacity: 0.1;
        }

        .stat-card {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
        }

        .icon-box {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(40, 167, 69, 0.03);
        }

        .btn-quick-action {
            border-radius: 12px;
            padding: 12px;
            transition: all 0.3s;
            border: 1px solid #eee;
            background: white;
        }

        .btn-quick-action:hover {
            border-color: #28a745;
            background: #f8fff9;
            transform: scale(1.05);
        }
    </style>
@endsection

@section('content')

    {{-- WELCOME BANNER --}}
    <div class="welcome-banner">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="fw-bold mb-2">Halo, Selamat Datang di Dashboard! 👋</h3>
                <p class="mb-0 opacity-75">Kelola arus kas Toko Snack Bu Ana dengan mudah dan cepat dalam satu layar.</p>
            </div>
        </div>
        <i class="bx bx-store bg-icon"></i>
    </div>

    {{-- CARDS --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-2">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-muted small fw-semibold">Saldo Saat Ini</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="fw-bold mb-0 me-2 text-dark">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                        <div class="icon-box bg-label-primary shadow-sm">
                            <i class="bx bx-wallet fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-2">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-muted small fw-semibold">Pemasukan</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="fw-bold mb-0 me-2 text-success">Rp {{ number_format($totalMasuk, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                        <div class="icon-box bg-label-success shadow-sm">
                            <i class="bx bx-trending-up fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-2">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-muted small fw-semibold">Pengeluaran</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="fw-bold mb-0 me-2 text-danger">Rp {{ number_format($totalKeluar, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                        <div class="icon-box bg-label-danger shadow-sm">
                            <i class="bx bx-trending-down fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-2">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-muted small fw-semibold">Total Aktivitas</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="fw-bold mb-0 me-2">{{ $totalTransaksi }}</h4>
                            </div>
                        </div>
                        <div class="icon-box bg-label-warning shadow-sm">
                            <i class="bx bx-refresh fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- GRAFIK --}}
        <div class="col-lg-8 mb-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-header bg-transparent py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Analisis Arus Kas</h5>
                    {{-- Navigasi Periode --}}
                    <ul class="nav nav-pills nav-sm bg-light rounded-3 p-1">
                        <li class="nav-item">
                            <button class="nav-link active py-1 px-3 small"
                                onclick="updateChart('mingguan')">Mingguan</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link py-1 px-3 small" onclick="updateChart('bulanan')">Bulanan</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link py-1 px-3 small" onclick="updateChart('tahunan')">Tahunan</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="chartUtama"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- QUICK ACTIONS & INFO --}}
        <div class="col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-header bg-transparent py-3 border-0">
                    <h5 class="fw-bold mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="/kas-masuk" class="btn-quick-action text-decoration-none d-flex align-items-center p-3">
                            <div class="icon-box bg-label-success me-3"><i class="bx bx-plus"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold">Input Kas Masuk</h6>
                                <small class="text-muted">Catat penjualan snack</small>
                            </div>
                        </a>
                        <a href="/kas-keluar" class="btn-quick-action text-decoration-none d-flex align-items-center p-3">
                            <div class="icon-box bg-label-danger me-3"><i class="bx bx-minus"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold">Input Kas Keluar</h6>
                                <small class="text-muted">Catat belanja modal/stok</small>
                            </div>
                        </a>
                        <a href="/laporan" class="btn-quick-action text-decoration-none d-flex align-items-center p-3">
                            <div class="icon-box bg-label-info me-3"><i class="bx bx-file"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold">Cetak Laporan</h6>
                                <small class="text-muted">Download PDF/Excel</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartUtama');

        // Data simulasi (Idealnya kamu kirim data ini dari Controller)
        // const dataPeriode = {
        //     mingguan: {
        //         labels: {!! json_encode($mingguanMasuk->pluck('tanggal')) !!}, // Data 7 hari terakhir
        //         masuk: {!! json_encode($mingguanMasuk->pluck('total')) !!},
        //         keluar: {!! json_encode($mingguanKeluar->pluck('total')) !!}
        //     },
        //     bulanan: {
        //         labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
        //         masuk: [500000, 700000, 450000, 800000],
        //         keluar: [300000, 400000, 250000, 500000]
        //     },
        //     tahunan: {
        //         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
        //         masuk: [2000000, 2500000, 2200000, 3000000, 2800000, 3500000],
        //         keluar: [1500000, 1800000, 1600000, 2000000, 1900000, 2200000]
        //     }
        // };

        const dataPeriode = {
            mingguan: {
                labels: {!! json_encode($mingguanMasuk->pluck('tanggal')) !!},
                masuk: {!! json_encode($mingguanMasuk->pluck('total')) !!},
                keluar: {!! json_encode($mingguanKeluar->pluck('total')) !!}
            },
            bulanan: {
                labels: {!! json_encode($bulananMasuk->pluck('bulan')) !!},
                masuk: {!! json_encode($bulananMasuk->pluck('total')) !!},
                keluar: {!! json_encode($bulananKeluar->pluck('total')) !!}
            },
            tahunan: {
                labels: {!! json_encode($tahunanMasuk->pluck('tahun')) !!},
                masuk: {!! json_encode($tahunanMasuk->pluck('total')) !!},
                keluar: {!! json_encode($tahunanKeluar->pluck('total')) !!}
            }
        };

        let chartKeuangan = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dataPeriode.mingguan.labels,
                datasets: [{
                        label: 'Pemasukan',
                        data: dataPeriode.mingguan.masuk,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    },
                    {
                        label: 'Pengeluaran',
                        data: dataPeriode.mingguan.keluar,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end'
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#000',
                        bodyColor: '#666',
                        borderColor: '#eee',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString(
                                    'id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f8f9fa'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Fungsi Update Grafik
        function updateChart(periode) {
            // Update Button Active State
            document.querySelectorAll('.nav-link').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Update Data
            chartKeuangan.data.labels = dataPeriode[periode].labels;
            chartKeuangan.data.datasets[0].data = dataPeriode[periode].masuk;
            chartKeuangan.data.datasets[1].data = dataPeriode[periode].keluar;
            chartKeuangan.update();
        }
    </script>

@endsection
