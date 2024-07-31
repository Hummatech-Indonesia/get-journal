@extends('layouts.no-auth')

@section('title', 'Login')

@section('top-text')

    <span class="text-gray-500 fw-bold fs-5 me-2">Belum memiliki akun?
        <a href="/register" class="link-primary fw-bold fs-5">Daftar</a>
        sekarang
    </span>

@endsection
@section('content')

@include('components.swal')

<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('login') }}" method="POST">
    @csrf
    <div class="card-body">
        <div class="text-start mb-10">
            <h1 class="text-gray-900 mb-3 fs-3x">Masuk</h1>
        </div>
        <div class="fv-row mb-8">
            <input type="text" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="off" class="form-control form-control-solid @error('email') is-invalid border-1 border-danger @enderror" />
            @error('email')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="fv-row mb-7">
            <input type="text" placeholder="Password" name="password" autocomplete="off" class="form-control form-control-solid @error('password') is-invalid border-1 border-danger @enderror" />
            @error('password')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-10">
            <div></div>
            {{-- <a href="#" class="link-primary">Lupa Password?</a> --}}
        </div>
        <div class="d-flex flex-stack">
            <button type="submit" class="btn btn-primary me-2 flex-shrink-0">Masuk</button>
        </div>
    </div>
</form>

@endsection