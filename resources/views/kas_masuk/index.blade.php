@extends('layouts.contentNavbarLayout')

@section('title', 'Kas Masuk')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="bx bx-down-arrow-circle text-success me-1"></i>
            Kas Masuk
        </h4>
        <p class="text-muted mb-0">Catat pemasukan toko</p>
    </div>

    <button
        class="btn btn-success"
        data-bs-toggle="modal"
        data-bs-target="#modalTambahKasMasuk"
    >
        <i class="bx bx-plus me-1"></i>
        Tambah Kas Masuk
    </button>
</div>

{{-- ================= TABEL ================= --}}
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Daftar Kas Masuk</h5>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Sumber</th>
                        <th>Keterangan</th>
                        <th class="text-end">Jumlah</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                            <td>{{ $item->sumber }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td class="text-success fw-semibold text-end">
                                +Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="text-center">

                                {{-- EDIT --}}
                                <button
                                    class="btn btn-sm btn-outline-secondary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditKasMasuk{{ $item->id }}"
                                >
                                    <i class="bx bx-edit"></i>
                                </button>

                                {{-- DELETE --}}
                                <form
                                    action="{{ route('kas-masuk.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>

                        {{-- ================= MODAL EDIT ================= --}}
                        <div class="modal fade" id="modalEditKasMasuk{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Kas Masuk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form method="POST" action="{{ route('kas-masuk.update', $item->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal</label>
                                                <input type="date" name="tanggal" class="form-control"
                                                    value="{{ $item->tanggal }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Jumlah (Rp)</label>
                                                <input type="number" name="jumlah" class="form-control"
                                                    value="{{ $item->jumlah }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Sumber</label>
                                                <input type="text" name="sumber" class="form-control"
                                                    value="{{ $item->sumber }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Keterangan</label>
                                                <textarea name="keterangan" class="form-control" rows="3">{{ $item->keterangan }}</textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-success w-100">
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
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
<div class="modal fade" id="modalTambahKasMasuk" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Kas Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('kas-masuk.store') }}">
                @csrf

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control"
                            value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control"
                            placeholder="100000" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sumber</label>
                        <input type="text" name="sumber" class="form-control"
                            placeholder="Penjualan Snack" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success w-100">
                        Tambah
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- ================= TOAST SUCCESS ================= --}}
@if(session('success'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast"
         class="toast text-bg-success border-0 show slide-in">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"></button>
        </div>
    </div>
</div>
@endif

{{-- ================= STYLE ANIMASI ================= --}}
<style>
    .slide-in {
        animation: slideInRight 0.4s ease-out;
    }
    .slide-out {
        animation: slideOutRight 0.4s ease-in forwards;
    }
    @keyframes slideInRight {
        from { transform: translateX(120%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(120%); opacity: 0; }
    }
</style>

{{-- ================= SCRIPT AUTO CLOSE ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toast = document.getElementById('successToast');
    if (toast) {
        setTimeout(() => {
            toast.classList.remove('slide-in');
            toast.classList.add('slide-out');
            setTimeout(() => toast.remove(), 400);
        }, 3000);
    }
});
</script>

@endsection
