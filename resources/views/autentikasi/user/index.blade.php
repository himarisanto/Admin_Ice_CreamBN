@extends('layout.master')
@section('content')
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    @foreach ($users as $data)
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            @isset($data->profil->foto_profil)
                                <img src="{{ asset('/profil_user/' . $data->profil->foto_profil) }}"  alt="Profile" class="rounded-circle">
                            @else
                                <img src="{{ asset('/template/assets/img/profile-img.jpg') }}"  alt="Profile" class="rounded-circle">
                            @endisset
                            <h2>{{ $data->profil->nama_lengkap ?? '-' }}</h2>
                            <h3>{{ $data->profil->job }}</h3>
                            <button class="btn btn-success"><i class="ri-whatsapp-line"></i> +62 {{ $data->profil->wa ?? '-' }}</button>

                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#user-edit">User</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Profile</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#password-edit">Password</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            @include('autentikasi.user.overview')
                            @include('autentikasi.user.edit_user')
                            @include('autentikasi.user.edit_profile')
                            @include('autentikasi.user.edit_password')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
