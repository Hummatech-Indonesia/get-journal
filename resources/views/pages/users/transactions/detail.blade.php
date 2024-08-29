@extends('layouts.auth')

@section('title', 'Detail Transaksi')

@section('content')
    @include('components.swal')
    <div class="card">
        <div class="card-body">
            Detail Transaksi
        </div>
    </div>
    <div class="d-flex gap-3 mt-5">
        <a href="{{route('transactions.index')}}" class="btn btn-sm btn-dark d-flex gap-2 justify-content-center align-items-center"><i class="ki-duotone ki-double-left fs-1"><span class="path1"></span><span class="path2"></span></i> Kembali</a>
        <a href="#" class="btn btn-sm btn-primary d-flex gap-2 justify-content-center align-items-center"><i class="ki-duotone ki-credit-cart fs-1"><span class="path1"></span><span class="path2"></span></i> Bayar</a>

    </div>
@endsection