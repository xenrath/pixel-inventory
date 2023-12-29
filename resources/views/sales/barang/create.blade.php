@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('sales/barang') }}">Barang</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Barang</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ url('sales/barang') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Masukan nama barang" value="{{ old('nama_barang') }}">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                placeholder="Masukan jumlah" value="{{ old('jumlah') }}">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan"
                                placeholder="Masukan satuan" value="{{ old('satuan') }}">
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar <small>(Kosongkan saja jika tidak
                                    ingin menambahkan)</small></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar" name="gambar"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar">Masukkan gambar</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Keterangan</label>
                            <textarea type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan keterangan">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
