@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex mb-2">
                <h1>Barang</h1>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Barang</h3>
                    <div class="float-right">
                        <a href="{{ url('admin/barang/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i>
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <form action="{{ url('admin/barang') }}" method="GET" id="get-keyword" autocomplete="off">
                        @csrf
                        <div class="row p-3">
                            <div class="col-0 col-md-8"></div>
                            <div class="col-md-4">
                                <label for="keyword">Cari Barang :</label>
                                <div class="input-group">
                                    <input type="search" class="form-control" name="keyword" id="keyword"
                                        value="{{ Request::get('keyword') }}"
                                        onsubmit="event.preventDefault();
                                        document.getElementById('get-keyword').submit();">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 40px">No</th>
                                    <th>Barang</th>
                                    <th>Stok</th>
                                    <th class="text-center" style="width: 140px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($barangs as $key => $barang)
                                    <tr>
                                        <td class="text-center">{{ $barangs->firstItem() + $key }}</td>
                                        <td class="text-wrap">{{ $barang->nama_barang }}</td>
                                        <td>
                                            {{ $barang->jumlah }} {{ $barang->satuan }}
                                        </td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modal-add-{{ $barang->id }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            {{-- <a href="{{ url('admin/barang/' . $barang->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a> --}}
                                            <a href="{{ url('admin/barang/' . $barang->id . '/edit') }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modal-hapus-{{ $barang->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-hapus-{{ $barang->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Barang</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus barang <strong>{{ $barang->nama }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('admin/barang/' . $barang->id) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modal-add-{{ $barang->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Perbarui Stok</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div style="text-align: center;">
                                                        <form action="{{ url('admin/stok/' . $barang->id) }}"
                                                            method="POST" enctype="multipart/form-data" autocomplete="off">
                                                            @csrf
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="jumlah">Stok</label>
                                                                    <input type="number" class="form-control"
                                                                        id="jumlah" name="jumlah"
                                                                        placeholder="Masukan jumlah"
                                                                        value="{{ old('jumlah', $barang->jumlah) }}">
                                                                </div>
                                                            </div>
                                                            <div class="card-footer text-right">
                                                                <button type="reset"
                                                                    class="btn btn-secondary">Reset</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </tr>
                                    <div class="modal fade" id="modal-detail-{{ $barang->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Detail Barang</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <strong>Kode</strong>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            {{ $barang->kode_barang }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <strong>Nama Barang</strong>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            {{ $barang->nama_barang }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <strong>Stok</strong>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            {{ $barang->jumlah }} {{ $barang->satuan }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <strong>Keterangan</strong>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            {{ $barang->keterangan ?? '-' }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <strong>Harga Pcs</strong>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            @rupiah($barang->harga_pcs)
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <strong>Harga Dus</strong>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            @rupiah($barang->harga_dus)
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <strong>Harga Renceng</strong>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            @rupiah($barang->harga_renceng)
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <strong>Harga Pack</strong>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            @rupiah($barang->harga_pack)
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($barang->gambar)
                                                            <div class="col">
                                                                <img src="{{ asset('storage/uploads/' . $barang->gambar) }}"
                                                                    alt="">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="4">- Barang tidak ditemukan -</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($barangs->total() > 10)
                    <div class="card-footer">
                        <div class="pagination float-right">
                            {{ $barangs->appends(Request::all())->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
