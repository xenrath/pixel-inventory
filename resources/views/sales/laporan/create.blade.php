@extends('layouts.app')

@section('title', 'Tambah Laporan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex mb-2 align-items-center">
                <a href="{{ url('sales/laporan') }}" class="btn btn-secondary mr-2">
                    <div class="fas fa-chevron-left"></div>
                </a>
                <h1>Laporan</h1>
            </div>
        </div>
    </div>
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
            <form action="{{ url('sales/laporan') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Buat Laporan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <textarea class="form-control" name="keterangan" placeholder="Tulis laporan harian" style="height: 300px;"
                                value ="">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script>
        $(function() {
            $('#summernote').summernote()
        })
    </script>
@endsection
