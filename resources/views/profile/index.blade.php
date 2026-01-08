@extends('layouts.contentNavbarLayout')

@section('title', 'Profil Saya')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-body">

                <h4 class="mb-4">
                    <i class="bx bx-user me-1"></i>
                    Profil Saya
                </h4>

                {{-- ALERT --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM --}}
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ Auth::user()->name }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ Auth::user()->email }}"
                            required
                        >
                    </div>

                    <hr>

                    <h6 class="mb-3 text-muted">Ganti Password (Opsional)</h6>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Minimal 6 karakter"
                        >
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                        >
                    </div>

                    <button class="btn btn-primary">
                        <i class="bx bx-save me-1"></i>
                        Simpan Perubahan
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
