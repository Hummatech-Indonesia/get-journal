@extends('layouts.auth')

@section('title', 'Premium')

@section('content')
    @include('components.swal')
    @include('pages.users.premium.widgets.index-payment-method-modal')
    @include('pages.users.premium.widgets.index-pricing')
@endsection

@push('script')
    <script src="{{ asset('assets/plugins/custom/number-format/number-format.js') }}"></script>
    <script src="{{asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js')}}"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>
@endpush

@push('style')
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css"
    />
@endpush
