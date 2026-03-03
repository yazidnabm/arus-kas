@extends('layouts.contentNavbarLayout')

@section('title', 'Kas Masuk')

@section('page-style')
    <style>
        /* Modern Table Styling */
        .table thead th { background-color: #f8f9fa; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 700; color: #6c757d; border-bottom: 2px solid #edf2f9; }
        .badge-date { background-color: rgba(40, 167, 69, 0.1); color: #28a745; font-weight: 600; padding: 0.5em 0.8em; border-radius: 8px; }
        .badge-qty { background-color: #f1f0f2; color: #696cff; font-weight: 700; padding: 0.4em 0.7em; border-radius: 6px; }
        .amount-text { font-family: 'Public Sans', sans-serif; font-size: 0.95rem; }
        .btn-action { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s; }

        /* PREMIUM FORM STYLE (Input Group Merge) */
        .modal-content { border: none; border-radius: 20px; box-shadow: 0 15px 50px rgba(0,0,0,0.15); }
        .modal-header { border-bottom: none; padding: 1.5rem 1.5rem 0.5rem; }
        .modal-footer { border-top: none; }
        
        .form-label { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: #566a7f; margin-bottom: 0.5rem; }
        
        .input-group-merge .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            color: #a1acb8;
            transition: all 0.2s ease;
        }
        
        .input-group-merge .form-control {
            border-left: none;
            padding-left: 0.5rem;
        }

        /* Focus State Dynamics */
        .input-group-merge:focus-within .input-group-text {
            border-color: #28a745;
            color: #28a745;
            background-color: #fff;
        }
        
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.1);
        }

        .bg-label-success { background-color: #e8fadf !important; color: #71dd37 !important; }
    </style>
@endsection

@section('content')

    {{-- ================= HEADER ================= --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="/dashboard" class="text-success">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kas Masuk</li>
                </ol>
            </nav>
            <h4 class="fw-bold mb-0">
                <i class="bx bx-down-arrow-circle text-success me-1"></i> Riwayat Kas Masuk
            </h4>
        </div>

        <button class="btn btn-success shadow-sm px-4 py-2 rounded-3 fw-bold" data-bs-toggle="modal"
            data-bs-target="#modalTambahKasMasuk">
            <i class="bx bx-plus me-1"></i> TAMBAH TRANSAKSI
        </button>
    </div>

    {{-- ================= TABEL DATA ================= --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Tanggal</th>
                            <th>Sumber Pemasukan</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-center px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td class="ps-4"><span class="text-muted fw-bold">{{ $loop->iteration }}</span></td>
                                <td>
                                    <span class="badge-date small">
                                        <i class="bx bx-calendar me-1"></i> {{ date('d/m/Y', strtotime($item->tanggal)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $item->sumber }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge-qty small">{{ $item->quantity }} Pcs</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-success fw-bold amount-text">
                                        + Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-center px-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-action btn-outline-secondary" data-bs-toggle="modal"
                                            data-bs-target="#modalEditKasMasuk{{ $item->id }}">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>

                                        <form action="{{ route('kas-masuk.destroy', $item->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-action btn-outline-danger">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- ================= MODAL EDIT ================= --}}
                            <div class="modal fade" id="modalEditKasMasuk{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <div class="bg-label-success p-2 rounded-3 me-3">
                                                <i class="bx bx-edit text-success fs-3"></i>
                                            </div>
                                            <div>
                                                <h5 class="modal-title fw-bold mb-0">Edit Transaksi</h5>
                                                <small class="text-muted">ID Transaksi: #{{ $item->id }}</small>
                                            </div>
                                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form method="POST" action="{{ route('kas-masuk.update', $item->id) }}">
                                            @csrf @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Tanggal</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                                            <input type="date" name="tanggal" class="form-control" value="{{ $item->tanggal }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Quantity</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="bx bx-package"></i></span>
                                                            <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}" min="1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Nominal Total (Rp)</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text fw-bold text-success">Rp</span>
                                                            <input type="number" name="jumlah" class="form-control" value="{{ $item->jumlah }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Sumber Pemasukan</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="bx bx-store-alt"></i></span>
                                                            <input type="text" name="sumber" class="form-control" value="{{ $item->sumber }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer p-4 pt-0">
                                                <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">SIMPAN PERUBAHAN</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bx bx-info-circle fs-4 mb-2 d-block"></i>
                                    Belum ada data kas masuk
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= MODAL TAMBAH ================= --}}
    <div class="modal fade" id="modalTambahKasMasuk" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <div class="bg-label-success p-2 rounded-3 me-3">
                        <i class="bx bx-plus-circle text-success fs-3"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Catat Pemasukan</h5>
                        <small class="text-muted">Masukkan rincian penjualan baru</small>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('kas-masuk.store') }}">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Quantity</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-package"></i></span>
                                    <input type="number" name="quantity" class="form-control" placeholder="1" min="1" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Nominal Total (Rp)</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text fw-bold text-success">Rp</span>
                                    <input type="number" name="jumlah" class="form-control" placeholder="0" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Sumber Pemasukan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-shopping-bag"></i></span>
                                    <input type="text" name="sumber" class="form-control" placeholder="Misal: Penjualan Snack" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-4 pt-0">
                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">TAMBAH TRANSAKSI</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Toast & Animasi Tetap Sama --}}
@endsection