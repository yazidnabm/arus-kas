{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.blankLayout')

@section('title', 'Login')

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner mx-auto" style="max-width: 420px;">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <div class="text-center mb-3">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width:64px;height:64px;">
                            <i class="bx bx-store text-white fs-3"></i>
                        </div>
                        <h4 class="fw-bold mb-0">Toko Snack Bu Ana</h4>
                        <small class="text-muted">Sistem Informasi Arus Kas</small>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger py-2">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn btn-success w-100 mb-2">
                            <i class="bx bx-log-in-circle me-1"></i> Masuk
                        </button>
                    </form>

                    <a href="{{ route('register') }}" class="btn btn-outline-success w-100">
                        <i class="bx bx-user-plus me-1"></i> Daftar Akun
                    </a>

                    <p class="text-center small text-muted mt-3 mb-0">
                        © {{ date('Y') }} Toko Snack Bu Ana
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
