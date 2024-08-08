@extends('layouts.auth')

@section('title', 'Siswa')

@section('content')
    @include('components.swal')
    @include('pages.users.students.widgets.index-dt_student_list')
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('assets/plugins/custom/datatablesnet/datatables.min.css')}}">
@endpush
@push('script')
    <script src="{{asset('assets/plugins/custom/datatablesnet/datatables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatablesnet/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatablesnet/vfs_fonts.js')}}"></script>
@endpush