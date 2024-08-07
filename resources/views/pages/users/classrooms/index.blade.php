@extends('layouts.auth')

@section('title', 'Kelas')

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="cari..." name="search">
                <div class="input-group-text">Cari</div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        @for ($i = 12; $i > 0; $i--)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card mb-5" style="background-image: linear-gradient(to bottom, rgba(0,0,0,.2), rgba(0,0,0,.8)), url({{asset('assets/media/stock/600x400/img-1.jpg')}});background-size: cover; min-height:150px;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-stetch">
                            <div class="h1 text-white mb-0">X RPL 1</div>
                            <div class="badge badge-xl border border-white rounded text-white">KH80UO</div>
                        </div>
                        <div class="text-white">oleh Nama Guru</div>
                    </div>
                    <div class="table-responsive d-flex gap-2 flex-nowrap">
                        <span class="badge border border-white rounded text-white">30 / 36 Siswa</span>
                        <span class="badge border border-white rounded text-white">99 Materi</span>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
@endsection