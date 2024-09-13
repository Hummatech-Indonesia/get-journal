@extends('layouts.auth')

@section('title', 'Profil')

@section('content')
    @include('components.swal')

    @include('pages.users.profiles.widgets.modal-password-edit')
    @include('pages.users.profiles.widgets.modal-profile-edit')

    <div class="card w-100 d-flex flex-column flex-md-row overflow-hidden">
        <div class="flex-1 w-100">
            <img src="{{ asset('assets/media/avatars/300-1.jpg') }}" alt="foto profile" class="w-100" style="object-fit: cover;">
        </div>
        <div class="flex-1 w-100 justify-self-stretch d-flex flex-column justify-content-between p-3">
            <div>
                <div class="mb-3">
                    <div class="text-muted fw-bolder">Nama</div>
                    <div class="fw-bolder fs-5">Nama hehe</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted fw-bolder">Email</div>
                    <div class="fw-bolder fs-5">Nama hehe</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted fw-bolder">Alamat</div>
                    <div class="fw-bolder fs-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis a consequatur voluptatem!</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted fw-bolder">Jenis Akun</div>
                    <div class="d-flex gap-2">
                        <span class="badge bg-light-primary text-primary">Siswa</span>
                        <span class="badge bg-light-info text-info">Guru</span>
                        <span class="badge bg-light-warning text-warning">Sekolah</span>
                        <span class="badge bg-light-success text-success">Admin</span>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row justify-content-stretch gap-2">
                <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        Ubah Password
                    </button>
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editProfileModal" id="openProfileModal" data-store="{&quot;id&quot;:&quot;5483051c-7c78-3763-848d-4926ad588ba6&quot;,&quot;name&quot;:&quot;Hany Jaya&quot;,&quot;logo&quot;:&quot;storage\/logo\/logo.jpeg&quot;,&quot;code_debt&quot;:&quot;101010&quot;,&quot;created_at&quot;:&quot;2024-07-24T06:36:11.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-08-28T07:16:24.000000Z&quot;}">
                        Ubah Profil
                    </button>
            </div>
        </div>
    </div>
@endsection