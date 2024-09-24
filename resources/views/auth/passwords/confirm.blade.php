@extends('layouts.no-auth')

@section('content')
<form class="form w-100" novalidate="novalidate" action="{{ route('password.confirm') }}" method="POST">
    @csrf
    <div class="card-body">
        <div class="text-start mb-10">
            <h1 class="text-gray-900 mb-3 fs-3x">Konfirmasi Password</h1>
        </div>
        <div class="fv-row mb-8">
            <input type="password" placeholder="Password" name="password" value="{{ old('password') }}" autocomplete="off" class="form-control active form-control-solid @error('password') is-invalid border-1 border-danger @enderror" />
            @error('password')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-10">
            <button type="submit" class="btn btn-primary me-2 flex-shrink-0">Konfirmasi</button>
            <a href="{{route('password.request')}}" class="link-primary">Lupa Password?</a>
        </div>
    </div>
</form>

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
