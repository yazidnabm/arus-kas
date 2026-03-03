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

        /* PREMIUM FORM STYLE (DANGER THEME) */
        .modal-content-out { border: none; border-radius: 20px; box-shadow: 0 15px 50px rgba(0,0,0,0.15); }
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

        /* Focus State (Red) */
        .input-group-merge:focus-within .input-group-text {
            border-color: #dc3545;
            color: #dc3545;
            background-color: #fff;
        }
        
        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.1);
        }

        .bg-label-danger { background-color: #ffe0e3 !important; color: #dc3545 !important; }
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

        <button class="btn btn-danger shadow-sm px-4 py-2 rounded-3 fw-bold" data-bs-toggle="modal"
            data-bs-target="#modalTambahKasKeluar">
            <i class="bx bx-plus me-1"></i> TAMBAH PENGELUARAN
        </button>
    </div>

    {{-- ================= TABEL DATA ================= --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
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
                                <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge-date-out small">
                                        <i class="bx bx-calendar-exclamation me-1"></i> {{ date('d/m/Y', strtotime($item->tanggal)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $item->tujuan }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge-qty-out small">{{ $item->quantity }} Pcs</span>
                                </td>
                                <td class="text-end">
                                    <span class="amount-out">
                                        - Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-center px-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-action-out btn-outline-secondary" data-bs-toggle="modal"
                                            data-bs-target="#modalEditKasKeluar{{ $item->id }}">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>

                                        <form action="{{ route('kas-keluar.destroy', $item->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus catatan pengeluaran ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-action-out btn-outline-danger">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- ================= MODAL EDIT ================= --}}
                            <div class="modal fade" id="modalEditKasKeluar{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content modal-content-out shadow-lg">
                                        <div class="modal-header d-flex align-items-center">
                                            <div class="bg-label-danger p-2 rounded-3 me-3">
                                                <i class="bx bx-edit text-danger fs-3"></i>
                                            </div>
                                            <div>
                                                <h5 class="modal-title fw-bold mb-0">Update Pengeluaran</h5>
                                                <small class="text-muted">ID Transaksi: #{{ $item->id }}</small>
                                            </div>
                                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form method="POST" action="{{ route('kas-keluar.update', $item->id) }}">
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
                                                            <span class="input-group-text fw-bold text-danger">Rp</span>
                                                            <input type="number" name="jumlah" class="form-control" value="{{ $item->jumlah }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Tujuan / Barang</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="bx bx-target-lock"></i></span>
                                                            <input type="text" name="tujuan" class="form-control" value="{{ $item->tujuan }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer p-4 pt-0">
                                                <button type="submit" class="btn btn-danger w-100 py-2 fw-bold shadow-sm">SIMPAN PERUBAHAN</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bx bx-info-circle fs-4 mb-2 d-block"></i>
                                    Belum ada catatan pengeluaran
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= MODAL TAMBAH ================= --}}
    <div class="modal fade" id="modalTambahKasKeluar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-out shadow-lg">
                <div class="modal-header d-flex align-items-center">
                    <div class="bg-label-danger p-2 rounded-3 me-3">
                        <i class="bx bx-minus-circle text-danger fs-3"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Catat Kas Keluar</h5>
                        <small class="text-muted">Masukkan rincian pengeluaran baru</small>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('kas-keluar.store') }}">
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
                                    <span class="input-group-text fw-bold text-danger">Rp</span>
                                    <input type="number" name="jumlah" class="form-control" placeholder="0" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Tujuan Pengeluaran</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-cart-alt"></i></span>
                                    <input type="text" name="tujuan" class="form-control" placeholder="Misal: Beli Bahan Baku" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-4 pt-0">
                        <button type="submit" class="btn btn-danger w-100 py-2 fw-bold shadow-sm">TAMBAH PENGELUARAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Toast & Script Logic sama dengan Kas Masuk (pastikan warna toast merah jika gagal/hapus) --}}
@endsection