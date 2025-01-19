@extends('layouts.app')

@section('title', 'Pengeluaran')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <a href="{{ url('admin/pengeluaran') }}" class="btn btn-secondary btn-flat float-left mr-2">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1>Pengeluaran</h1>
                </div>
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
            <form action="{{ url('admin/pengeluaran/' . $pengeluaran->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="card rounded-0">
                            <div class="card-header">
                                <h3 class="card-title">Supplier</h3>
                                <button type="button" class="btn btn-info btn-sm btn-flat float-right" data-toggle="modal"
                                    data-target="#modal-supplier">
                                    Pilih
                                </button>
                            </div>
                            <div class="card-body">
                                @error('supplier_id')
                                    <div class="alert alert-danger alert-dismissible rounded-0">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">&times;</button>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="p-4 text-center border rounded-0" id="supplier-kosong">
                                    <span class="text-muted">- Supplier belum dipilih -</span>
                                </div>
                                <div id="supplier-detail" style="display: none;">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <strong>Nama Supplier</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <span id="supplier-nama">-</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <strong>No. Telepon</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <span id="supplier-telp">-</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <strong>Alamat</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <span id="supplier-alamat">-</span>
                                        </div>
                                    </div>
                                    <input type="hidden" id="supplier-id" name="supplier_id" class="form-control rounded-0"
                                        value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card rounded-0">
                            <div class="card-header">
                                <h3 class="card-title">Sales</h3>
                                <button type="button" class="btn btn-info btn-sm btn-flat float-right" data-toggle="modal"
                                    data-target="#modal-sales">
                                    Pilih
                                </button>
                            </div>
                            <div class="card-body">
                                @error('user_id')
                                    <div class="alert alert-danger alert-dismissible rounded-0">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">&times;</button>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="p-4 text-center border rounded-0" id="sales-kosong">
                                    <span class="text-muted">- Sales belum dipilih -</span>
                                </div>
                                <div id="sales-detail" style="display: none;">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <strong>Nama Supplier</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <span id="sales-nama">-</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <strong>No. Telepon</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <span id="sales-telp">-</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <strong>Alamat</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <span id="sales-alamat">-</span>
                                        </div>
                                    </div>
                                    <input type="hidden" id="sales-id" name="user_id" class="form-control rounded-0"
                                        value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card rounded-0">
                    <div class="card-header">
                        <h3 class="card-title">Barang</h3>
                        <button type="button" class="btn btn-info btn-sm btn-flat float-right" data-toggle="modal"
                            data-target="#modal-barang">
                            Pilih
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @error('barangs')
                            <div class="alert alert-danger alert-dismissible rounded-0">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                {{ $message }}
                            </div>
                        @enderror
                        <div id="barang-alert" class="alert alert-info alert-dismissible rounded-0"
                            style="display: none;">
                            <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">&times;</button>
                            Lakukan <strong>uncheck</strong> untuk menghapus barang
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 20px" class="text-center">No</th>
                                    <th>Barang</th>
                                    <th style="width: 240px;">
                                        Harga
                                        <small class="text-muted">(per satuan)</small>
                                    </th>
                                    <th style="width: 160px;">Jumlah</th>
                                    <th style="width: 160px;">Total</th>
                                </tr>
                            </thead>
                            <tbody id="barang-tbody">
                                <tr id="barang-kosong">
                                    <td class="text-center text-muted" colspan="5">
                                        - Barang belum ditambahkan -
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Grand Total</th>
                                    <th colspan="2">
                                        <span id="span-grand-total">Rp0</span>
                                        <input type="hidden" class="form-control" name="grand_total" id="grand-total"
                                            value="0">
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="mb-4 text-right">
                    <button type="submit" class="btn btn-primary btn-flat">Simpan Pengeluaran</button>
                </div>
            </form>
        </div>
        <div class="modal fade" id="modal-supplier" data-backdrop="static">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Supplier</h4>
                    </div>
                    <div class="modal-header shadow-sm mb-2">
                        <div class="input-group">
                            <input type="search" class="form-control rounded-0" id="keyword-supplier"
                                placeholder="cari nama / alamat supplier" autocomplete="off">
                            <div class="input-group-append rounded-0">
                                <button type="button" class="btn btn-default btn-flat" onclick="supplier_search()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <table id="supplier-modal-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 20px;">No</th>
                                    <th>Supplier</th>
                                    <th class="text-center" style="width: 40px;">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="supplier-modal-tbody">
                                @foreach ($suppliers as $supplier)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <span>{{ $supplier->nama_supp }}</span>
                                            <br>
                                            <small class="text-muted">{{ $supplier->alamat }}</small>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                                data-dismiss="modal" onclick="supplier_set({{ $supplier->id }})">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="supplier-modal-loading" class="text-center p-4" style="display: none">
                            <span>Loading...</span>
                        </div>
                        <div class="text-center">
                            <small class="text-muted">Cari dengan <strong>kata kunci</strong> lebih detail</small>
                            <br>
                            <small class="text-muted">Menampilkan maksimal 10 data</small>
                        </div>
                    </div>
                    <div class="modal-footer shadow-sm justify-content-between">
                        <button type="button" class="btn btn-default btn-sm btn-flat"
                            data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-sales" data-backdrop="static">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sales</h4>
                    </div>
                    <div class="modal-header shadow-sm mb-2">
                        <div class="input-group">
                            <input type="search" class="form-control rounded-0" id="keyword-sales"
                                placeholder="cari nama / alamat sales" autocomplete="off">
                            <div class="input-group-append rounded-0">
                                <button type="button" class="btn btn-default btn-flat" onclick="sales_search()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <table id="sales-modal-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 20px;">No</th>
                                    <th>Sales</th>
                                    <th class="text-center" style="width: 40px;">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="sales-modal-tbody">
                                @foreach ($saless as $sales)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <span>{{ $sales->nama }}</span>
                                            <br>
                                            <small class="text-muted">{{ $sales->alamat }}</small>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                                data-dismiss="modal" onclick="sales_set({{ $sales->id }})">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="sales-modal-loading" class="text-center p-4" style="display: none">
                            <span>Loading...</span>
                        </div>
                        <div class="text-center">
                            <small class="text-muted">Cari dengan <strong>kata kunci</strong> lebih detail</small>
                            <br>
                            <small class="text-muted">Menampilkan maksimal 10 data</small>
                        </div>
                    </div>
                    <div class="modal-footer shadow-sm justify-content-between">
                        <button type="button" class="btn btn-default btn-sm btn-flat"
                            data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-barang" data-backdrop="static">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Barang</h4>
                    </div>
                    <div class="modal-header shadow-sm mb-2">
                        <div class="input-group">
                            <input type="search" class="form-control rounded-0" id="keyword-barang"
                                placeholder="cari nama barang" autocomplete="off">
                            <div class="input-group-append rounded-0">
                                <button type="button" class="btn btn-default btn-flat" onclick="barang_search()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <table id="barang-modal-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 20px;">#</th>
                                    <th>Barang</th>
                                    <th style="max-width: 200px;">Harga</th>
                                </tr>
                            </thead>
                            <tbody id="barang-modal-tbody">
                                @foreach ($barangs as $barang)
                                    <tr>
                                        <td class="text-center">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="barang-checkbox-{{ $barang->id }}"
                                                    onclick="barang_get({{ $barang->id }})">
                                                <label for="barang-checkbox-{{ $barang->id }}"></label>
                                            </div>
                                        </td>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td style="max-width: 200px;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>per Pcs:</strong>
                                                    <span>@rupiah($barang->harga_pcs)</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>per Dus:</strong>
                                                    <span>@rupiah($barang->harga_dus)</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>per Renceng</strong>
                                                    <span>@rupiah($barang->harga_renceng)</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>per Pack</strong>
                                                    <span>@rupiah($barang->harga_pack)</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="barang-modal-loading" class="text-center p-4" style="display: none">
                            <span>Loading...</span>
                        </div>
                        <div class="text-center">
                            <small class="text-muted">Cari dengan <strong>kata kunci</strong> lebih detail</small>
                            <br>
                            <small class="text-muted">Menampilkan maksimal 10 data</small>
                        </div>
                    </div>
                    <div class="modal-footer shadow-sm justify-content-end">
                        <button type="button" class="btn btn-primary btn-sm btn-flat"
                            data-dismiss="modal">Selesai</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $('#keyword-supplier').on('search', function() {
            supplier_search();
        });

        function supplier_search() {
            $('#supplier-modal-table').hide();
            $('#supplier-modal-tbody').empty();
            $('#supplier-modal-loading').show();
            $.ajax({
                url: "{{ url('supplier-search') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "keyword": $('#keyword-supplier').val(),
                },
                dataType: "json",
                success: function(data) {
                    $('#supplier-modal-loading').hide();
                    $('#supplier-modal-table').show();
                    if (data.length) {
                        $.each(data, function(key, value) {
                            supplier_modal(key, value);
                        });
                    } else {
                        var tbody = '<tr>';
                        tbody += '<td class="text-center" colspan="3">';
                        tbody += '<span class="text-muted">- Data tidak ditemukan -</span>';
                        tbody += '</td>';
                        tbody += '</tr>';
                        $('#supplier-modal-tbody').append(tbody);
                    }
                },
            });
        }

        function supplier_modal(key, value) {
            var no = key + 1;
            var tbody = '<tr>';
            tbody += '<td class="text-center">' + no + '</td>';
            tbody += '<td>';
            tbody += '<span>' + value.nama_supp + '</span>';
            tbody += '<br>';
            tbody += '<small class="text-muted">' + value.alamat + '</small>';
            tbody += '<td class="text-center">';
            tbody +=
                '<button type="button" class="btn btn-outline-primary btn-sm btn-flat" data-dismiss="modal" onclick="supplier_set(' +
                value.id + ')">';
            tbody += '<i class="fas fa-check"></i>';
            tbody += '</button>';
            tbody += '</td>';
            tbody += '</tr>';

            $('#supplier-modal-tbody').append(tbody);
        }

        function supplier_set(id) {
            $.ajax({
                url: "{{ url('supplier-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#supplier-kosong').hide();
                        $('#supplier-detail').show();
                        $('#supplier-nama').text(data.nama_supp ?? '-');
                        $('#supplier-telp').text(data.telp ?? '-');
                        $('#supplier-alamat').text(data.alamat ?? '-');
                        $('#supplier-id').val(data.id);
                    } else {
                        $('#supplier-kosong').show();
                        $('#supplier-detail').hide();
                        $('#supplier-id').val("");
                    }
                },
            });
        }

        var supplier_id = @json(old('supplier_id', $pengeluaran->supplier_id));
        if (supplier_id) {
            supplier_set(supplier_id);
        }
    </script>
    <script>
        $('#keyword-sales').on('search', function() {
            sales_search();
        });

        function sales_search() {
            $('#sales-modal-table').hide();
            $('#sales-modal-tbody').empty();
            $('#sales-modal-loading').show();
            $.ajax({
                url: "{{ url('sales-search') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "keyword": $('#keyword-sales').val(),
                },
                dataType: "json",
                success: function(data) {
                    $('#sales-modal-loading').hide();
                    $('#sales-modal-table').show();
                    if (data.length) {
                        $.each(data, function(key, value) {
                            sales_modal(key, value);
                        });
                    } else {
                        var tbody = '<tr>';
                        tbody += '<td class="text-center" colspan="3">';
                        tbody += '<span class="text-muted">- Data tidak ditemukan -</span>';
                        tbody += '</td>';
                        tbody += '</tr>';
                        $('#sales-modal-tbody').append(tbody);
                    }
                },
            });
        }

        function sales_modal(key, value) {
            var no = key + 1;
            var tbody = '<tr>';
            tbody += '<td class="text-center">' + no + '</td>';
            tbody += '<td>';
            tbody += '<span>' + value.nama + '</span>';
            tbody += '<br>';
            tbody += '<small class="text-muted">' + value.alamat + '</small>';
            tbody += '<td class="text-center">';
            tbody +=
                '<button type="button" class="btn btn-outline-primary btn-sm btn-flat" data-dismiss="modal" onclick="sales_set(' +
                value.id + ')">';
            tbody += '<i class="fas fa-check"></i>';
            tbody += '</button>';
            tbody += '</td>';
            tbody += '</tr>';

            $('#sales-modal-tbody').append(tbody);
        }

        function sales_set(id) {
            $.ajax({
                url: "{{ url('sales-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#sales-kosong').hide();
                        $('#sales-detail').show();
                        $('#sales-nama').text(data.nama ?? '-');
                        $('#sales-telp').text(data.telp ?? '-');
                        $('#sales-alamat').text(data.alamat ?? '-');
                        $('#sales-id').val(data.id);
                    } else {
                        $('#sales-kosong').show();
                        $('#sales-detail').hide();
                        $('#sales-id').val("");
                    }
                },
            });
        }

        var user_id = @json(old('user_id', $pengeluaran->user_id));
        if (user_id) {
            sales_set(user_id);
        }
    </script>
    <script>
        $('#keyword-barang').on('search', function() {
            barang_search();
        });

        function barang_search() {
            $('#barang-modal-table').hide();
            $('#barang-modal-tbody').empty();
            $('#barang-modal-loading').show();
            $.ajax({
                url: "{{ url('barang-search') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "keyword": $('#keyword-barang').val(),
                },
                dataType: "json",
                success: function(data) {
                    $('#barang-modal-loading').hide();
                    $('#barang-modal-table').show();
                    if (data.length) {
                        $.each(data, function(key, value) {
                            barang_modal(value, barang_item.includes(value.id));
                        });
                    } else {
                        var tbody = '<tr>';
                        tbody += '<td class="text-center" colspan="3">';
                        tbody += '<span class="text-muted">- Data tidak ditemukan -</span>';
                        tbody += '</td>';
                        tbody += '</tr>';
                        $('#barang-modal-tbody').append(tbody);
                    }
                },
            });
        }

        function barang_modal(value, is_selected) {
            if (is_selected) {
                var checked = 'checked';
            } else {
                var checked = '';
            }

            var tbody = '<tr>';
            tbody += '<td class="text-center">';
            tbody += '<div class="icheck-primary d-inline">';
            tbody += '<input type="checkbox" id="barang-checkbox-' + value.id + '"';
            tbody += 'onclick="barang_get(' + value.id + ')" ' + checked + '>';
            tbody += '<label for="barang-checkbox-' + value.id + '"></label>';
            tbody += '</div>';
            tbody += '</td>';
            tbody += '<td>' + value.nama_barang + '</td>';
            tbody += '<td style="max-width: 200px;">';
            tbody += '<div class="row">';
            tbody += '<div class="col-md-6">';
            tbody += '<strong>per Pcs:</strong>';
            tbody += '<span>' + rupiah(value.harga_pcs) + '</span>';
            tbody += '</div>';
            tbody += '<div class="col-md-6">';
            tbody += '<strong>per Dus:</strong>';
            tbody += '<span>' + rupiah(value.harga_dus) + '</span>';
            tbody += '</div>';
            tbody += '<div class="col-md-6">';
            tbody += '<strong>per Renceng</strong>';
            tbody += '<span>' + rupiah(value.harga_renceng) + '</span>';
            tbody += '</div>';
            tbody += '<div class="col-md-6">';
            tbody += '<strong>per Pack</strong>';
            tbody += '<span>' + rupiah(value.harga_pack) + '</span>';
            tbody += '</div>';
            tbody += '</div>';
            tbody += '</td>';
            tbody += '</tr>';
            $('#barang-modal-tbody').append(tbody);
        }

        var barang_item = [];

        function barang_get(id) {
            var check = $('#barang-checkbox-' + id).prop('checked');
            if (check) {
                if (!barang_item.includes(id)) {
                    var key = barang_item.length;
                    $.ajax({
                        url: "{{ url('barang-get') }}" + "/" + id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            barang_set(key, data);
                        },
                    });
                    barang_item.push(id);
                }
            } else {
                barang_delete(id);
            }
            if (barang_item.length > 0) {
                $('#barang-kosong').hide();
                $('#barang-alert').show();
            } else {
                $('#barang-kosong').show();
                $('#barang-alert').hide();
            }
        }

        function barang_set(key, value, is_old = false) {
            var satuan = "";
            var harga = "";
            var is_harga = "readonly";
            var jumlah = 1;
            var total = 0;
            if (is_old) {
                satuan = value.satuan;
                harga = value.harga;
                is_harga = "";
                jumlah = value.jumlah;
                total = value.total;
            }
            var no = key + 1;
            tbody = '<tr id="barang-list-' + value.id + '">';
            tbody += '<td id="urutan" class="text-center">' + no + '</td>';
            tbody += '<td>';
            tbody += '<span>' + value.nama_barang + '</span>';
            tbody += '<input type="hidden" class="form-control rounded-0" name="barangs[' + key + '][id]" value="' + value
                .id + '">';
            tbody += '<input type="hidden" class="form-control rounded-0" name="barangs[' + key +
                '][nama_barang]" value="' + value
                .nama_barang + '">';
            tbody += '</td>';
            tbody += '<td>';
            tbody += '<select id="barang-satuan-' + value.id +
                '" name="barangs[' + key + '][satuan]" class="form-control rounded-0 mb-2" onchange="harga_get(' +
                value.id +
                ')" required>';
            tbody += '<option value="">- pilih satuan -</option>';
            tbody += '<option value="pcs" ' + (satuan == "pcs" ? "selected" : "") + '>Pcs</option>';
            tbody += '<option value="dus" ' + (satuan == "dus" ? "selected" : "") + '>Dus</option>';
            tbody += '<option value="renceng" ' + (satuan == "renceng" ? "selected" : "") + '>Renceng</option>';
            tbody += '<option value="pack" ' + (satuan == "pack" ? "selected" : "") + '>Pack</option>';
            tbody += '</select>';
            tbody += '<input type="number" class="form-control rounded-0" id="barang-harga-' + value.id +
                '" name="barangs[' + key + '][harga]" placeholder="pilih satuan" onkeyup="get_total(' + value.id +
                ')" value="' + harga + '" ' + is_harga + ' required>';
            tbody += '</td>';
            tbody += '<td>';
            tbody += '<input type="number" class="form-control rounded-0" id="barang-jumlah-' + value.id +
                '" value="' + jumlah + '" name="barangs[' + key + '][jumlah]" onkeyup="get_total(' + value.id +
                ')" required>';
            tbody += '</td>';
            tbody += '<td style="width=200px">';
            tbody += '<span id="barang-total-' + value.id + '">' + rupiah("" + total, "Rp") + '</span>';
            tbody += '<input type="hidden" class="form-control total" id="total-' + value.id +
                '" name="barangs[' + key + '][total]" value="' + total + '" required>';
            tbody += '</td>';
            tbody += '</tr>';
            $('#barang-tbody').append(tbody);
        }

        function barang_delete(id) {
            $('#barang-list-' + id).remove();
            barang_item = barang_item.filter(i => i !== id);
            if (barang_item.length > 0) {
                var urutan = document.querySelectorAll('#urutan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            } else {
                $('#barang-kosong').show();
                $('#barang-alert').hide();
            }
            set_grand_total();
        }

        function harga_get(id) {
            $.ajax({
                url: "{{ url('harga-get') }}" + '/' + id,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "satuan": $('#barang-satuan-' + id).val(),
                },
                success: function(data) {
                    if (data) {
                        harga = data;
                        $('#barang-harga-' + id).prop('readonly', false);
                        $('#barang-harga-' + id).val(data);
                    } else {
                        harga = 0;
                        $('#barang-harga-' + id).prop('readonly', true);
                        $('#barang-harga-' + id).val("");
                    }
                    get_total(id);
                },
            });
        }

        function get_total(id, is_select = false) {
            var harga = $('#barang-harga-' + id).val();
            var jumlah = $('#barang-jumlah-' + id).val();
            var total = 0;
            if (harga !== "" && jumlah !== "") {
                total = parseInt(harga) * parseInt(jumlah);
                ' + jumlah + '
            }
            $('#barang-total-' + id).text(rupiah("" + total, "Rp"));
            $('#total-' + id).val(total);

            set_grand_total();

            if (is_select) {
                $('#satuan-' + id).val($('#harga-' + id).find(':selected').data('satuan'));
            }
        }

        function set_grand_total() {
            var grand_total = 0;
            $('.total').each(function() {
                var total = parseFloat($(this).val())
                grand_total += total;
            })

            $('#span-grand-total').text(rupiah("" + grand_total, "Rp"));
            $('#grand-total').val(grand_total);
        }

        function rupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
        }

        var old_barangs = @json(old('barangs', $old_barangs));
        if (old_barangs !== null) {
            if (old_barangs.length > 0) {
                $('#barang-tbody').empty();
                $.each(old_barangs, function(key, value) {
                    barang_item.push(parseInt(value.id));
                    $('#barang-checkbox-' + value.id).prop('checked', true);
                    barang_set(key, value, true);
                });
            }
        }

        var grand_total = @json(old('grand_total', $pengeluaran->grand_total));
        if (grand_total) {
            $('#span-grand-total').text(rupiah("" + grand_total, "Rp"));
            $('#grand-total').val(grand_total);
        }
    </script>
@endsection
