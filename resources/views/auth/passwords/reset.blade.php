@extends('layouts.no-auth')

@section('content')
@section('title', 'Ubah Password')
@include('components.swal')
<form class="form w-100" novalidate="novalidate" action="{{ route('web.update-forgot-password') }}" method="POST">
    @csrf
    <div class="card-body">
        <div class="text-start mb-10">
            <h1 class="text-gray-900 mb-3 fs-3x">Reset Password</h1>
        </div>
        <input type="hidden" name="type" value="web">   
        <input type="hidden" name="token" value="{{ $check->token }}">   
        <div class="fv-row mb-8">
            <input type="password" placeholder="Password" name="new_password" value="" autocomplete="off" class="form-control active form-control-solid @error('password') is-invalid border-1 border-danger @enderror" />
            @error('password')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="fv-row mb-8">
            <input type="password" placeholder="Konfirmasi Password" name="confirm_password" value="" autocomplete="off" class="form-control active form-control-solid @error('password') is-invalid border-1 border-danger @enderror" />
            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-10">
            <button type="submit" class="btn btn-primary me-2 flex-shrink-0">Reset Password</button>
        </div>
    </div>
</form>

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
