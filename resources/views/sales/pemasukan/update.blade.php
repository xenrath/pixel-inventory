@extends('layouts.app')

@section('title', 'Perbarui Pemasukan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Perbarui Pemasukan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('sales/pemasukan') }}">Perbarui Pemasukan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
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
            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @if (session('error_pelanggans'))
                        @foreach (session('error_pelanggans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                    @if (session('error_pesanans'))
                        @foreach (session('error_pesanans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                </div>
            @endif
            <form action="{{ url('sales/pemasukan/' . $pemasukan->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                </div>
                <div>
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Supplier</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="supplier_id">Supplier Id</label>
                                            <input type="text" class="form-control" id="supplier_id" readonly
                                                name="supplier_id" placeholder=""
                                                value="{{ old('supplier_id', $pemasukan->supplier_id) }}">
                                        </div>
                                        <label style="font-size:14px" class="form-label" for="nama_supp">Nama</label>
                                        <div class="form-group d-flex">
                                            <input class="form-control" id="nama_supp" name="nama_supp" type="text"
                                                placeholder="" value="{{ old('nama_supp', $pemasukan->nama_supp) }}"
                                                readonly style="margin-right: 10px; font-size:14px" />
                                            <button class="btn btn-primary" type="button"
                                                onclick="showSupplier(this.value)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="telp">No. Telp</label>
                                            <input style="font-size:14px" type="text" class="form-control" id="telp"
                                                readonly name="telp" placeholder=""
                                                value="{{ old('telp', $pemasukan->telp) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="alamat">Alamat</label>
                                            <input style="font-size:14px" type="text" class="form-control" id="alamat"
                                                readonly name="alamat" placeholder=""
                                                value="{{ old('alamat', $pemasukan->alamat) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Sales</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="user_id">User Id</label>
                                            <input type="text" class="form-control" id="user_id" readonly
                                                name="user_id" placeholder=""
                                                value="{{ old('user_id', $pemasukan->user_id) }}">
                                        </div>
                                        <label style="font-size:14px" class="form-label" for="nama_driver">Nama
                                            Sales</label>
                                        <div class="form-group d-flex">
                                            <input class="form-control" id="nama" name="nama" type="text"
                                                placeholder="" value="{{ old('nama', $pemasukan->nama) }}" readonly
                                                style="margin-right: 10px;font-size:14px" />
                                            <button class="btn btn-primary" type="button"
                                                onclick="showSales(this.value)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="telp_sales">No. Telp</label>
                                            <input style="font-size:14px" type="tex" class="form-control"
                                                id="telp_sales" readonly name="telp_sales" placeholder=""
                                                value="{{ old('telp_sales', $pemasukan->telp_sales) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="alamat_sales">Alamat</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="alamat_sales" readonly name="alamat_sales" placeholder=""
                                                value="{{ old('alamat_sales', $pemasukan->alamat_sales) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Barang</h3>
                                <div class="float-right">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#modal-barang">
                                        Pilih Barang
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card" id="card-barang-kosong">
                            <div class="card-body">
                                <p class="text-center">- Barang belum dipilih -</p>
                            </div>
                        </div>
                        <div class="row" id="row-barang"></div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <strong>Grand Total</strong>
                                    </div>
                                    <div class="col-6 text-right">
                                        <span id="span-grand-total">Rp0</span>
                                        <input type="hidden" class="form-control" name="grand_total" id="grand-total"
                                            value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right pt-3 pb-5">
                            <button type="submit" class="btn btn-primary">Simpan Pemasukan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="tableSupplier" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Supplier</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="datatables" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Supplier</th>
                                        <th>Nama Supplier</th>
                                        <th>Telp</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $supplier)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $supplier->kode_supplier }}</td>
                                            <td>{{ $supplier->nama_supp }}</td>
                                            <td>{{ $supplier->telp }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedSupplier('{{ $supplier->id }}', '{{ $supplier->nama_supp }}', '{{ $supplier->telp }}', '{{ $supplier->alamat }}')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="tableSales" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sales</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="datatables1" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Sales</th>
                                        <th>Telp</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $saless)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $saless->nama }}</td>
                                            <td>{{ $saless->telp }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedSales('{{ $saless->id }}', '{{ $saless->nama }}', '{{ $saless->telp }}', '{{ $saless->alamat }}')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-barang" data-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Barang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 40px">#</th>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>H.Pcs</th>
                                        <th>H.Dus</th>
                                        <th>H.Renceng</th>
                                        <th>H.Pack</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangs as $barang)
                                        @php
                                            if (in_array($barang->id, array_keys($detail_id_data))) {
                                                $detail_id = $detail_id_data[$barang->id];
                                            } else {
                                                $detail_id = 0;
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-center">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="checkbox-barang-{{ $barang->id }}"
                                                        onclick="add_item({{ $barang->id }}, {{ $detail_id }})">
                                                    <label for="checkbox-barang-{{ $barang->id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ $barang->jumlah }} {{ $barang->satuan }}</td>
                                            <td>@rupiah($barang->harga_pcs)</td>
                                            <td>@rupiah($barang->harga_dus)</td>
                                            <td>@rupiah($barang->harga_renceng)</td>
                                            <td>@rupiah($barang->harga_pack)</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Selesai</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function showSupplier(selectedCategory) {
            $('#tableSupplier').modal('show');
        }

        function getSelectedSupplier(Supplier_id, NamaSup, Telp, Alamat) {
            document.getElementById('supplier_id').value = Supplier_id;
            document.getElementById('nama_supp').value = NamaSup;
            document.getElementById('telp').value = Telp;
            document.getElementById('alamat').value = Alamat;
            $('#tableSupplier').modal('hide');
        }
    </script>
    <script>
        function showSales(selectedCategory) {
            $('#tableSales').modal('show');
        }

        function getSelectedSales(Sales_id, Nama, Telps, Alamats) {
            document.getElementById('user_id').value = Sales_id;
            document.getElementById('nama').value = Nama;
            document.getElementById('telp_sales').value = Telps;
            document.getElementById('alamat_sales').value = Alamats;
            $('#tableSales').modal('hide');
        }
    </script>
    <script>
        var item_id = [];

        function add_item(id, detail_id) {
            var checkbox = document.getElementById('checkbox-barang-' + id);
            if (checkbox.checked) {
                if (!item_id.includes(id)) {
                    item_id.push(id);
                    $.ajax({
                        url: "{{ url('sales/pemasukan/get_item') }}" + '/' + id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            set_item(data);
                        },
                    });
                }
                if (item_id.length > 0) {
                    $('#card-barang-kosong').hide();
                }
            } else {
                delete_item(id, detail_id);
            }
        }

        function set_item(data, is_session = false) {
            var satuan = '';
            var jumlah = 1;
            var total = 0;
            var detail_id = 0;

            if (is_session) {
                document.getElementById('checkbox-barang-' + data.id).checked = true;
                satuan = data.satuan;
                jumlah = data.jumlah;
                total = data.total;
                detail_id = data.detail_id;
            }

            var col = '<div class="col-md-4" id="col-barang-' + data.id + '">';
            col += '<div class="card">';
            col += '<div class="card-body">';
            col += '<div class="d-flex justify-content-between align-items-top">';
            col += '<strong>' + data.nama_barang + '</strong>';
            col += '<input type="hidden" class="form-control" name="id[]" value="' + data.id + '">';
            col += '<div>';
            col += '<button type="button" class="btn btn-danger btn-sm" onclick="delete_item(' + data.id + ', ' +
                detail_id + ')">';
            col += '<div class="fas fa-trash"></div>';
            col += '</button>';
            col += '</div>';
            col += '</div>';
            col += '<hr class="mb-2">';
            col += '<div class="form-group mb-2">';
            col += '<label for="harga-' + data.id + '">Harga <small>(satuan)</small></label>';
            col += '<select class="form-control" name="harga[' + data.id + ']" id="harga-' + data.id +
                '" onchange="get_total(' + data.id + ', ' + true + ')">';
            col += '<option value="">Pilih</option>';
            col += '<option value="' + data.harga_pcs + '" data-satuan="pcs" ' + (satuan == "pcs" ? "selected" : "") + '>' +
                rupiah(data.harga_pcs ??
                    "0", "Rp") +
                ' (pcs)</option>';
            col += '<option value="' + data.harga_dus + '" data-satuan="dus" ' + (satuan == "dus" ? "selected" : "") + '>' +
                rupiah(data.harga_dus ??
                    "0", "Rp") +
                ' (dus)</option>';
            col += '<option value="' + data.harga_renceng + '" data-satuan="renceng" ' + (satuan == "renceng" ? "selected" :
                    "") + '>' + rupiah(data
                    .harga_renceng ?? "0",
                    "Rp") +
                ' (renceng)</option>';
            col += '<option value="' + data.harga_pack + '" data-satuan="pack" ' + (satuan == "pack" ? "selected" : "") +
                '>' + rupiah(data
                    .harga_pack ?? "0", "Rp") +
                ' (pack)</option>';
            col += '</select>';
            col += '<input type="hidden" class="form-control" name="satuan[' + data.id + ']" id="satuan-' + data.id +
                '" value="' + satuan + '">';
            col += '</div>';
            col += '<div class="form-group mb-2">';
            col += '<label for="jumlah-' + data.id + '">Jumlah</label>';
            col +=
                '<input type="number" id="jumlah-' + data.id + '" name="jumlah[' + data.id +
                ']" class="form-control" oninput="this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null" onkeyup="get_total(' +
                data.id + ')" value="' + jumlah + '">';
            col += '</div>';
            col += '<hr>';
            col += '<div class="d-flex justify-content-between">';
            col += '<strong>Total</strong>';
            col += '<strong>';
            col += '<span id="span-total-' + data.id + '">' + rupiah("" + total, "Rp") + '</span>';
            col += '</strong>';
            col += '<input type="hidden" class="form-control total" id="total-' + data.id +
                '" name="total[' + data.id +
                ']" value="' + total + '">';
            col += '</div>';
            col += '</div>';
            col += '</div>';
            col += '</div>';

            $('#row-barang').append(col);

            if (is_session) {
                set_grand_total();
            }
        }

        function delete_item(id, detail_id) {
            $('#col-barang-' + id).remove();
            item_id = item_id.filter(i => i !== id);

            document.getElementById('checkbox-barang-' + id).checked = false;
            if (item_id.length === 0) {
                $('#card-barang-kosong').show();
            }

            if (detail_id !== 0) {
                $.ajax({
                    url: "{{ url('sales/pemasukan/delete_item') }}" + '/' + detail_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#checkbox-barang-' + id).attr('onclick', 'add_item(' + id + ', 0)');
                    },
                });
            }

            set_grand_total();
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

        function get_total(id, is_select = false) {
            var harga = $('#harga-' + id).val();
            var jumlah = $('#jumlah-' + id).val();
            var total = 0;
            if (harga !== "" && jumlah !== "") {
                total = parseInt(harga) * parseInt(jumlah);
            }

            $('#span-total-' + id).text(rupiah("" + total, "Rp"));
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

        var data_item = @json(session('data_pembelians'));

        if (data_item !== null) {
            if (data_item.length > 0) {
                $('#card-barang-kosong').hide();
                $.each(data_item, function(key, value) {
                    item_id.push(value.id);
                    set_item(value, true);
                });
            }
        } else {
            data_item = @json($details);
            if (data_item.length > 0) {
                $('#card-barang-kosong').hide();
                $.each(data_item, function(key, value) {
                    item_id.push(value.id);
                    set_item(value, true);
                });
            }
        }
    </script>
@endsection
