@extends('layouts.no-auth')

@section('title', 'Login')

@section('top-text')

    <span class="text-gray-500 fw-bold fs-5 me-2">Sudah memiliki akun?
        <a href="/login" class="link-primary fw-bold fs-5">Masuk</a>
        sekarang
    </span>

@endsection
@section('content')

<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">
    <!--begin::Body-->
    <div class="card-body">
        <!--begin::Heading-->
        <div class="text-start mb-10">
            <!--begin::Title-->
            <h1 class="text-gray-900 mb-3 fs-3x">Daftar</h1>
            <!--end::Title-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="Nama" name="name" autocomplete="off" class="form-control form-control-solid" />
            <!--end::Email-->
        </div>
        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="email" placeholder="Email" name="email" autocomplete="off" class="form-control form-control-solid" />
            <!--end::Email-->
        </div>
        <!--begin::Input group=-->
        <!--end::Input group=-->
        <div class="fv-row mb-7">
            <!--begin::Password-->
            <input type="text" placeholder="Password" name="password" autocomplete="off" class="form-control form-control-solid" />
            <!--end::Password-->
        </div>
        <!--end::Input group=-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-10">
            <div></div>
            <!--begin::Link-->
            <a href="#" class="link-primary">Lupa Password?</a>
            <!--end::Link-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Actions-->
        <div class="d-flex flex-stack">
            <!--begin::Submit-->
            <button type="submit" class="btn btn-primary me-2 flex-shrink-0">Daftar</button>
            <!--end::Submit-->
        </div>
        <!--end::Actions-->
    </div>
    <!--begin::Body-->
</form>

@endsection
