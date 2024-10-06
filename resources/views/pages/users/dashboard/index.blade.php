@extends('layouts.auth')

@section('title', 'Dashboard')
@section('alt-title', ('Selamat Datang '.Auth::user()->profile->name))

@push('style')
    <link rel="stylesheet" href="{{asset('assets/plugins/custom/datatablesnet/datatables.min.css')}}">
    <style>
        .card-dashboard i {
            bottom: -20px;
            right: 0px
        }
    </style>
@endpush

@section('content')
    {{-- <div class="d-flex justify-content-end mb-3">
        <div class="d-flex gap-3">
            <select name="filter_year" id="filter_year" class="form-select form-select-sm">
                <option value="" selected disabled>filter tahun</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
            </select>
            <select name="filter_month" id="filter_month" class="form-select form-select-sm">
                <option value="" selected disabled>filter bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
            </select>
        </div>
    </div> --}}

    @include('pages.users.dashboard.widgets.index-score_card')

    <div class="row">
        <div class="mb-5 col-12 col-lg-6">
            @include('pages.users.dashboard.widgets.index-dt_newest_teacher')
        </div>
        <div class="mb-5 col-12 col-lg-6">
            @include('pages.users.dashboard.widgets.index-dt_newest_journal')
        </div>
        <div class="col-12">
            @include('pages.users.dashboard.widgets.index-dt_premium')
        </div>
    </div>

    @include('components.swal')
@endsection

@push('script')
    <script src="{{asset('assets/plugins/custom/datatablesnet/datatables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatablesnet/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatablesnet/vfs_fonts.js')}}"></script>
@endpush