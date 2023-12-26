@extends('layouts.app')

@section('title', 'Lihat User')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/user') }}">User</a>
                    </li>
                    <li class="breadcrumb-item active">Lihat</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lihat User</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        @if ($user->gambar)
                        <img src="{{ asset('storage/uploads/' . $user->gambar) }}"
                            alt="{{ $user->nama_lengkap }}" class="w-100 rounded border">
                        @else
                        <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                            alt="{{ $user->nama_lengkap }}" class="w-100 rounded border">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Kode User</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $user->kode_user }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Role</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $user->role }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Telepon</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $user->telp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Alamat</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $user->alamat }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection