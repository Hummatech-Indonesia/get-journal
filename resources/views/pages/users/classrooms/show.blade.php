@extends('layouts.auth')

@section('title', 'Kelas')

@section('content')
    @include('components.swal')

    <div class="d-flex justify-content-end">
        <div class="btn-group btn-group-sm mb-3">
            @foreach($all_classrooms as $room)
            <a href="{{ route('classes.show', $room->id) }}" class="btn btn-light-info {{ $room->id == $classroom->id ? 'active' : '' }}">{{ $room->name }}</a>
            @endforeach
        </div>
    </div>

    <div class="card mb-5" style="background-image: linear-gradient(to bottom, rgba(0,0,0,.2), rgba(0,0,0,.8)), url({{ $classroom->background->image ? asset('storage').'/'.$classroom->background->image : asset('assets/media/books/img-72.jpg') }});background-size: cover; min-height:150px;">
        <div class="card-body d-flex flex-column justify-content-between">
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-stetch">
                    <div class="h1 text-white mb-0">{{$classroom->name}}</div>
                    <div class="badge badge-xl border border-white rounded text-white">{{$classroom->code}}</div>
                </div>
                <div class="text-white">oleh {{$classroom->profile->name}}</div>
            </div>
            <div class="table-responsive d-flex gap-2 flex-nowrap">
                <span class="badge border border-white rounded text-white">{{$classroom->students->count()}} / {{$classroom->limit}} Siswa</span>
                <span class="badge border border-white rounded text-white">{{$classroom->assignments->count()}} Tugas</span>
                <span class="badge border border-white rounded text-white">{{$classroom->journals->count()}} Jurnal</span>
            </div>
        </div>
    </div>

    @include('pages.users.classrooms.widgets.show-dt_student_list')
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('assets/plugins/custom/datatablesnet/datatables.min.css')}}">
@endpush
@push('script')
    <script src="{{asset('assets/plugins/custom/datatablesnet/datatables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatablesnet/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatablesnet/vfs_fonts.js')}}"></script>
@endpush