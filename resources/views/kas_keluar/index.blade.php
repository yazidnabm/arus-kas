@extends('layouts.contentNavbarLayout')

@section('title', 'Kas Keluar')

@section('page-style')
    <style>
        /* Modern Table Styling */
        .table thead th { background-color: #fcfcfc; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 700; color: #8592a3; border-bottom: 2px solid #f0f2f4; }
        .badge-date-out { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; font-weight: 600; padding: 0.5em 0.8em; border-radius: 8px; }
        .badge-qty-out { background-color: #fff1f2; color: #e91e63; font-weight: 700; padding: 0.4em 0.7em; border-radius: 6px; }
        .amount-out { font-family: 'Public Sans', sans-serif; font-weight: 700; color: #dc3545; }
        .btn-action-out { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s; }

        /* Widget Stats */
        .card-widget { border: none; border-radius: 15px; overflow: hidden; transition: transform 0.3s; }
        .card-widget:hover { transform: translateY(-5px); }

        /* PREMIUM FORM STYLE */
        .modal-content-out { border: none; border-radius: 20px; box-shadow: 0 15px 50px rgba(0,0,0,0.15); }
        .form-label { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: #566a7f; margin-bottom: 0.5rem; }
        .input-group-merge .input-group-text { background-color: #f8f9fa; border-right: none; color: #a1acb8; }
        .input-group-merge .form-control { border-left: none; padding-left: 0.5rem; }
        .form-control:focus { border-color: #dc3545; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.1); }
        .bg-label-danger { background-color: #ffe0e3 !important; color: #dc3545 !important; }
        
        .pagination { margin-bottom: 0; gap: 5px; }
        .page-item.active .page-link { background-color: #dc3545; border-color: #dc3545; }
        .page-link { border-radius: 8px !important; color: #dc3545; }
    </style>
@endsection

@section('content')

    {{-- ================= HEADER ================= --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="/dashboard" class="text-danger">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kas Keluar</li>
                </ol>
            </nav>
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bx bx-up-arrow-circle text-danger me-1"></i> Riwayat Kas Keluar
            </h4>
        </div>

        <button class="btn btn-danger shadow-sm px-4 py-2 rounded-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahKasKeluar">
            <i class="bx bx-plus me-1"></i> TAMBAH PENGELUARAN
        </button>
    </div>

    {{-- ================= STATS WIDGETS ================= --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card card-widget shadow-sm border-start border-danger border-5">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted d-block mb-1">Total Pengeluaran (Global)</small>
                            <h4 class="fw-bold mb-0 text-danger">Rp {{ number_format($totalPengeluaranAll, 0, ',', '.') }}</h4>
                        </div>
                        <div class="bg-label-danger p-3 rounded-3">
                            <i class="bx bx-trending-down fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-widget shadow-sm border-start border-secondary border-5">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted d-block mb-1">Barang Dibeli (Qty)</small>
                            <h4 class="fw-bold mb-0 text-secondary">{{ $totalItemOutAll }} Pcs</h4>
                        </div>
                        <div class="bg-label-secondary p-3 rounded-3">
                            <i class="bx bx-cart-download fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-widget shadow-sm border-start border-dark border-5">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted d-block mb-1">Alokasi Terbanyak</small>
                            <h4 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">
                                {{ $tujuanTerbanyak->tujuan ?? 'N/A' }}
                                <span class="text-muted small">({{ $tujuanTerbanyak->total_transaksi ?? 0 }}x)</span>
                            </h4>
                        </div>
                        <div class="bg-label-dark p-3 rounded-3">
                            <i class="bx bx-purchase-tag fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= TABEL DATA DENGAN FILTER ================= --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header border-0 pt-4 pb-2">
            <form action="{{ route('kas-keluar.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="small text-muted">Tampilkan</label>
                        <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted">Rentang Tanggal</label>
                        <div class="input-group input-group-sm">
                            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                            <span class="input-group-text">s/d</span>
                            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                            <button type="submit" class="btn btn-danger"><i class="bx bx-filter-alt"></i></button>
                            @if($startDate || $endDate)
                                <a href="{{ route('kas-keluar.index') }}" class="btn btn-outline-secondary"><i class="bx bx-refresh"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="small text-muted">Cari</label>
                        <div class="input-group input-group-merge input-group-sm">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" id="tableSearch" class="form-control" placeholder="Cari tujuan...">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0" id="mainTable">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Tanggal</th>
                            <th>Tujuan Pengeluaran</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Total Jumlah</th>
                            <th class="text-center px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td class="ps-4 text-muted">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                                <td>
                                    <span class="badge-date-out small">
                                        <i class="bx bx-calendar-exclamation me-1"></i> {{ date('d/m/Y', strtotime($item->tanggal)) }}
                                    </span>
                                </td>
                                <td><span class="fw-bold text-dark">{{ $item->tujuan }}</span></td>
                                <td class="text-center"><span class="badge-qty-out small">{{ $item->quantity }} Pcs</span></td>
                                <td class="text-end"><span class="amount-out">- Rp {{ number_format($item->jumlah, 0, ',', '.') }}</span></td>
                                <td class="text-center px-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-action-out btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalEditKasKeluar{{ $item->id }}">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>
                                        <form action="{{ route('kas-keluar.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus catatan pengeluaran ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-action-out btn-outline-danger"><i class="bx bx-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL EDIT --}}
                            <div class="modal fade" id="modalEditKasKeluar{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content modal-content-out shadow-lg">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Update Pengeluaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('kas-keluar.update', $item->id) }}">
                                            @csrf @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Tanggal</label>
                                                        <input type="date" name="tanggal" class="form-control" value="{{ $item->tanggal }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Quantity</label>
                                                        <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Nominal (Rp)</label>
                                                        <input type="number" name="jumlah" class="form-control" value="{{ $item->jumlah }}" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Tujuan</label>
                                                        <input type="text" name="tujuan" class="form-control" value="{{ $item->tujuan }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer p-4 pt-0">
                                                <button type="submit" class="btn btn-danger w-100 py-2 fw-bold">SIMPAN PERUBAHAN</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada catatan pengeluaran</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <small class="text-muted">Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} data</small>
                <div>{{ $data->appends(request()->query())->links('pagination::bootstrap-5') }}</div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambahKasKeluar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-out shadow-lg">
                <div class="modal-header d-flex align-items-center">
                    <div class="bg-label-danger p-2 rounded-3 me-3"><i class="bx bx-minus-circle text-danger fs-3"></i></div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Catat Kas Keluar</h5>
                        <small class="text-muted">Masukkan rincian baru</small>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('kas-keluar.store') }}">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6"><label class="form-label fw-bold">Tanggal</label><input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required></div>
                            <div class="col-md-6"><label class="form-label fw-bold">Quantity</label><input type="number" name="quantity" class="form-control" placeholder="1" min="1" required></div>
                            <div class="col-12"><label class="form-label fw-bold text-danger">Nominal Total (Rp)</label><input type="number" name="jumlah" class="form-control" placeholder="0" required></div>
                            <div class="col-12"><label class="form-label fw-bold">Tujuan Pengeluaran</label><input type="text" name="tujuan" class="form-control" placeholder="Misal: Beli Bahan Baku" required></div>
                        </div>
                    </div>
                    <div class="modal-footer p-4 pt-0"><button type="submit" class="btn btn-danger w-100 py-2 fw-bold">TAMBAH PENGELUARAN</button></div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('tableSearch').addEventListener('keyup', function() {
            let val = this.value.toLowerCase();
            document.querySelectorAll('#mainTable tbody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(val) ? '' : 'none';
            });
        });
    </script>
@endsection