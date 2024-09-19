@extends('layouts.auth')

@section('title', 'Siswa')

@section('content')
    @include('components.swal')
    <div class="card">
        <div class="card-body d-flex align-items-center gap-5">
            <div class="symbol symbol-100px">
                <img src="{{ asset($student->photo ? $student->photo : '/assets/media/avatars/blank.png') }}" alt="">
            </div>
            <div>
                <div class="fw-bolder fs-3">{{ $student->name }}</div>
                <div class="lead">{{ $student->user->email }}</div>
                <div class="mt-3">
                    <span class="badge bg-primary text-white">{{$student->classrooms->count()}} kelas</span>
                    <span class="badge bg-info text-white">{{$student->lessons->count()}} Pembelajaran</span>
                    <span class="badge bg-success text-white">{{$student->journals->count()}} Jurnal</span>
                </div>
                <div class="mt-1">
                    <span class="badge bg-light-success text-success">{{$student->permit->count()}} izin</span>
                    <span class="badge bg-light-primary text-primary">{{$student->sick->count()}} sakit</span>
                    <span class="badge bg-light-danger text-danger">{{$student->alpha->count()}} tanpa keterangan</span>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('assets/plugins/custom/datatablesnet/datatables.min.css')}}">
@endpush
@push('script')
    <script src="{{asset('assets/plugins/custom/datatablesnet/datatables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatablesnet/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatablesnet/vfs_fonts.js')}}"></script>
@endpush