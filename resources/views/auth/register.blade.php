{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.blankLayout')

@section('title', 'Register')

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner mx-auto" style="max-width: 420px;">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <div class="text-center mb-3">
                        <h4 class="fw-bold">Daftar Akun</h4>
                        <small class="text-muted">Toko Snack Bu Ana</small>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button class="btn btn-success w-100 mb-2">
                            <i class="bx bx-user-check me-1"></i> Daftar
                        </button>
                    </form>

                    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
                        Sudah punya akun? Login
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
