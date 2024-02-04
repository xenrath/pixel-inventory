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
                        <li class="breadcrumb-item"><a href="{{ url('admin/pemasukan') }}">Perbarui Pemasukan</a></li>
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
            <form action="{{ url('admin/pemasukan/' . $pemasukan->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Supplier</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group" hidden>
                                    <label for="supplier_id">Supplier Id</label>
                                    <input type="text" class="form-control" id="supplier_id" readonly name="supplier_id"
                                        placeholder="" value="{{ old('supplier_id', $pemasukan->supplier_id) }}">
                                </div>
                                <label style="font-size:14px" class="form-label" for="nama_supp">Nama</label>
                                <div class="form-group d-flex">
                                    <input class="form-control" id="nama_supp" name="nama_supp" type="text"
                                        placeholder="" value="{{ old('nama_supp', $pemasukan->nama_supp) }}" readonly
                                        style="margin-right: 10px; font-size:14px" />
                                    <button class="btn btn-primary" type="button" onclick="showSupplier(this.value)">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="telp">No. Telp</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="telp"
                                        readonly name="telp" placeholder="" value="{{ old('telp', $pemasukan->telp) }}">
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
                                    <input type="text" class="form-control" id="user_id" readonly name="user_id"
                                        placeholder="" value="{{ old('user_id', $pemasukan->user_id) }}">
                                </div>
                                <label style="font-size:14px" class="form-label" for="nama_driver">Nama
                                    Sales</label>
                                <div class="form-group d-flex">
                                    <input class="form-control" id="nama" name="nama" type="text" placeholder=""
                                        value="{{ old('nama', $pemasukan->nama) }}" readonly
                                        style="margin-right: 10px;font-size:14px" />
                                    <button class="btn btn-primary" type="button" onclick="showSales(this.value)">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="telp_sales">No. Telp</label>
                                    <input style="font-size:14px" type="tex" class="form-control" id="telp_sales"
                                        readonly name="telp_sales" placeholder=""
                                        value="{{ old('telp_sales', $pemasukan->telp_sales) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="alamat_sales">Alamat</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="alamat_sales"
                                        readonly name="alamat_sales" placeholder=""
                                        value="{{ old('alamat_sales', $pemasukan->alamat_sales) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Barang <span>
                            </span></h3>
                        <div class="float-right">
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                data-target="#modal-barang">
                                Pilih Barang
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 40px" class="text-center">No</th>
                                    <th>Nama Barang</th>
                                    <th style="width: 220px;">
                                        Harga
                                        <small>(satuan)</small>
                                    </th>
                                    <th style="width: 180px;">Jumlah</th>
                                    <th style="width: 220px;">Total</th>
                                    <th class="text-center" style="width: 40px;">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-barang">
                                {{-- @foreach ($details as $detail)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $detail->nama_barang }}</td>
                                        <td>
                                            @if ($detail->satuan == 'pcs')
                                                @rupiah($detail->harga_pcs) (pcs)
                                            @elseif($detail->satuan == 'dus')
                                                @rupiah($detail->harga_dus) (dus)
                                            @elseif($detail->satuan == 'renceng')
                                                @rupiah($detail->harga_renceng) (renceng)
                                            @elseif($detail->satuan == 'pack')
                                                @rupiah($detail->harga_pack) (pack)
                                            @endif
                                        </td>
                                        <td>{{ $detail->jumlah }}</td>
                                        <td>@rupiah($detail->total)</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach --}}
                                <tr id="tabel-barang-kosong" style="display: none">
                                    <td class="text-center" colspan="6">
                                        - Belum ada barang yang dipilih -
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Grand Total</th>
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
                <div class="text-right pt-3 pb-5">
                    <button type="submit" class="btn btn-primary">Simpan Pemasukan</button>
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
                                        <th>Harga Pcs</th>
                                        <th>Harga Dus</th>
                                        <th>Harga Renceng</th>
                                        <th>Harga Pack</th>
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
        var item_id = [];

        function add_item(id, detail_id) {
            var checkbox = document.getElementById('checkbox-barang-' + id);
            if (checkbox.checked) {
                if (!item_id.includes(id)) {
                    item_id.push(id);
                    $.ajax({
                        url: "{{ url('admin/pemasukan/get_item') }}" + '/' + id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var urutan = item_id.length;
                            set_item(urutan, data);
                        },
                    });
                }
                if (item_id.length > 0) {
                    $('#tabel-barang-kosong').hide();
                }
            } else {
                delete_item(id, detail_id);
            }
        }

        function set_item(urutan, data, is_session = false) {
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

            var col = '<tr id="tr-barang-' + data.id + '">';
            col += '<td class="text-center" id="urutan">' + urutan + '</td>';
            col += '<td>';
            col += '<input type="hidden" class="form-control" name="id[]" value="' + data.id + '">';
            col += data.nama_barang;
            col += '</td>';
            col += '<td>';
            col += '<div class="form-group mb-0">';
            col += '<select class="form-control" id="harga-' + data.id + '" name="harga[' + data.id +
                ']" onchange="get_total(' + data.id + ', ' + true + ')">';
            col += '<option value="">Pilih</option>';
            col += '<option value="' + data.harga_pcs + '" data-satuan="pcs" ' + (satuan == "pcs" ? "selected" : "") +
                '>' + rupiah(data.harga_pcs ??
                    "0", "Rp") +
                ' (pcs)</option>';
            col += '<option value="' + data.harga_dus + '" data-satuan="dus" ' + (satuan == "dus" ? "selected" : "") +
                '>' + rupiah(data.harga_dus ??
                    "0", "Rp") +
                ' (dus)</option>';
            col += '<option value="' + data.harga_renceng + '" data-satuan="renceng" ' + (satuan == "renceng" ?
                "selected" : "") + '>' + rupiah(data
                .harga_renceng ?? "0",
                "Rp") + ' (renceng)</option>';
            col += '<option value="' + data.harga_pack + '" data-satuan="pack" ' + (satuan == "pack" ? "selected" :
                    "") + '>' + rupiah(data
                    .harga_pack ?? "0", "Rp") +
                ' (pack)</option>';
            col += '</select>';
            col += '<input type="hidden" class="form-control" name="satuan[' + data.id + ']" id="satuan-' + data.id +
                '" value="' + satuan + '">';
            col += '</div>';
            col += '</td>';
            col += '<td>';
            col += '<div class="form-group mb-0">';
            col += '<input type="number" class="form-control" id="jumlah-' + data.id +
                '" name="jumlah[' + data.id +
                ']" oninput="this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null" onkeyup="get_total(' +
                data.id + ')" value="' + jumlah + '">';
            col += '</div>';
            col += '</td>';
            col += '<td>';
            col += '<span id="span-total-' + data.id + '">' + rupiah("" + total, "Rp") + '</span>';
            col += '<input type="hidden" class="form-control total" id="total-' + data.id +
                '" name="total[' + data.id +
                ']" value="' + total + '">';
            col += '</td>';
            col += '<td class="text-center">';
            col += '<button type="button" class="btn btn-danger btn-sm" onclick="delete_item(' + data.id + ', ' + detail_id + ')">';
            col += '<i class="fas fa-trash"></i>';
            col += '</button>';
            col += '</td>';
            col += '</tr>';

            $('#tabel-barang').append(col);

            if (is_session) {
                set_grand_total();
            }
        }

        function delete_item(id, detail_id) {
            $('#tr-barang-' + id).remove();
            item_id = item_id.filter(i => i !== id);

            document.getElementById('checkbox-barang-' + id).checked = false;
            if (item_id.length === 0) {
                $('#tabel-barang-kosong').show();
            } else {
                var urutan = document.querySelectorAll('#urutan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }

            if (detail_id !== 0) {
                $.ajax({
                    url: "{{ url('admin/pemasukan/delete_item') }}" + '/' + detail_id,
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
                $('#tabel-barang-kosong').hide();
                $.each(data_item, function(key, value) {
                    item_id.push(value.id);
                    var urutan = item_id.length;
                    set_item(urutan, value, true);
                });
            }
        } else {
            data_item = @json($details);
            if (data_item.length > 0) {
                $('#tabel-barang-kosong').hide();
                $.each(data_item, function(key, value) {
                    item_id.push(value.id);
                    var urutan = item_id.length;
                    set_item(urutan, value, true);
                });
            }
        }
    </script>

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

    {{-- <script>
        var activeSpecificationIndex = 0;

        function barang(param) {
            activeSpecificationIndex = param;
            $('#tableBarang').modal('show');
        }

        function getBarang(rowIndex) {
            var selectedRow = $('#datatables66 tbody tr:eq(' + rowIndex + ')');
            var barang_id = selectedRow.data('id');
            var kode_barang = selectedRow.data('kode_barang');
            var nama_barang = selectedRow.data('nama_barang');
            var harga_pcs = selectedRow.data('harga_pcs');
            var harga_dus = selectedRow.data('harga_dus');
            var jumlah = 0;
            var total = 0;

            $('#barang_id-' + activeSpecificationIndex).val(barang_id);
            $('#kode_barang-' + activeSpecificationIndex).val(kode_barang);
            $('#nama_barang-' + activeSpecificationIndex).val(nama_barang);
            $('#harga_pcs-' + activeSpecificationIndex).val(harga_pcs.toLocaleString('id-ID'));
            $('#harga_dus-' + activeSpecificationIndex).val(harga_dus.toLocaleString('id-ID'));
            $('#jumlah-' + activeSpecificationIndex).val(jumlah);
            $('#total-' + activeSpecificationIndex).val(total);

            updateGrandTotal()
            $('#tableBarang').modal('hide');
        }
    </script> --}}

    {{-- <script>
        // function Hitung(startingElement) {
        //     $(document).on("input", startingElement, function() {
        //         var currentRow = $(this).closest('tr');
        //         var satuan = currentRow.find('select[name="satuan[]"]').val();
        //         var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;
        //         var harga_pcs = parseFloat(currentRow.find(".harga_pcs").val().replace(/\./g, '')) || 0;
        //         var harga_dus = parseFloat(currentRow.find(".harga_dus").val().replace(/\./g, '')) || 0;

        //         if (satuan === 'pcs') {
        //             var harga_jual = harga_pcs * jumlah;
        //         } else if (satuan === 'dus') {
        //             var harga_jual = harga_dus * jumlah;
        //         } else {
        //             // Handle other cases if needed
        //             var harga_jual = 0;
        //         }

        //         currentRow.find(".total").val(harga_jual.toLocaleString('id-ID'));

        //         updateGrandTotal();
        //     });
        // }

        function Hitung(startingElement) {
            function updateTotal(currentRow) {
                var satuan = currentRow.find('select[name="satuan[]"]').val();
                var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;
                var harga_pcs = parseFloat(currentRow.find(".harga_pcs").val().replace(/\./g, '')) || 0;
                var harga_dus = parseFloat(currentRow.find(".harga_dus").val().replace(/\./g, '')) || 0;

                var harga_jual = 0;

                if (satuan === 'pcs') {
                    harga_jual = harga_pcs * jumlah;
                } else if (satuan === 'dus') {
                    harga_jual = harga_dus * jumlah;
                }

                currentRow.find(".total").val(harga_jual.toLocaleString('id-ID'));
                updateGrandTotal();
            }

            $(document).on("input", startingElement, function() {
                var currentRow = $(this).closest('tr');
                updateTotal(currentRow);
            });

            $(document).on("change", 'select[name="satuan[]"]', function() {
                var currentRow = $(this).closest('tr');
                updateTotal(currentRow);
            });
        }

        function updateGrandTotal() {
            var grandTotal = 0;
            $('input[name^="total"]').each(function() {
                var nominalValue = parseFloat($(this).val().replace(/\./g, '')) || 0;
                grandTotal += nominalValue;
            });
            $('#grand_total').val(grandTotal.toLocaleString('id-ID'));
        }

        $(document).ready(function() {
            Hitung(".jumlah");
            Hitung(".harga_dus");
            updateGrandTotal();
        });
    </script> --}}

    {{-- <script>
        var data_barang = @json(session('data_pembelians'));
        var jumlah_barang = 1;

        if (data_barang != null) {
            jumlah_barang = data_barang.length;
            $('#tabel-barang').empty();
            var urutan = 0;
            $.each(data_barang, function(key, value) {
                urutan = urutan + 1;
                itemBarang(urutan, key, value);
            });
        }

        function updateUrutan() {
            var urutan = document.querySelectorAll('#urutanbarang');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }

        var counter = 0;

        function addBarang() {
            counter++;
            jumlah_barang = jumlah_barang + 1;

            if (jumlah_barang === 1) {
                $('#tabel-barang').empty();
            } else {
                // Find the last row and get its index to continue the numbering
                var lastRow = $('#tabel-barang tr:last');
                var lastRowIndex = lastRow.find('#urutanbarang').text();
                jumlah_barang = parseInt(lastRowIndex) + 1;
            }

            console.log('Current jumlah_barang:', jumlah_barang);
            itemBarang(jumlah_barang, jumlah_barang - 1);
            updateUrutan();
        }

        function removeBarang(identifier) {
            var row = document.getElementById('barang-' + identifier);
            row.remove();

            // $.ajax({
            //     url: "{{ url('admin/detail_pemasukan/') }}/" + detailId,
            //     type: "POST",
            //     data: {
            //         _method: 'DELETE',
            //         _token: '{{ csrf_token() }}'
            //     },
            //     success: function(response) {
            //         console.log('Data deleted successfully');
            //     },
            //     error: function(error) {
            //         console.error('Failed to delete data:', error);
            //     }
            // });

            updateUrutan();
            updateGrandTotal()
        }

        function itemBarang(identifier, key, value = null) {
            var barang_id = '';
            var kode_barang = '';
            var nama_barang = '';
            var harga_pcs = '';
            var harga_dus = '';
            var satuan = '';
            var jumlah = '';
            var total = '';

            if (value !== null) {
                barang_id = value.barang_id;
                kode_barang = value.kode_barang;
                nama_barang = value.nama_barang;
                harga_pcs = value.harga_pcs;
                harga_dus = value.harga_dus;
                satuan = value.satuan;
                jumlah = value.jumlah;
                total = value.total;
            }

            // key 
            var itembarangs = '<tr id="barang-' + key + '">';
            itembarangs += '<td  style="width: 70px; font-size:14px" class="text-center" id="urutanbarang">' + key +
                '</td>';

            // barang_id 
            itembarangs += '<td hidden>';
            itembarangs += '<div class="form-group">'
            itembarangs += '<input type="text" class="form-control" style="font-size:14px" id="barang_id-' +
                key +
                '" name="barang_id[]" value="' + barang_id + '" ';
            itembarangs += '</div>';
            itembarangs += '</td>';

            // kode_barang 
            itembarangs += '<td>';
            itembarangs += '<div class="form-group">'
            itembarangs += '<input type="text" class="form-control" readonly style="font-size:14px" id="kode_barang-' +
                key +
                '" name="kode_barang[]" value="' + kode_barang + '" ';
            itembarangs += '</div>';
            itembarangs += '</td>';

            // nama_barang 
            itembarangs += '<td>';
            itembarangs += '<div class="form-group">'
            itembarangs += '<input type="text" class="form-control" readonly style="font-size:14px" id="nama_barang-' +
                key +
                '" name="nama_barang[]" value="' + nama_barang + '" ';
            itembarangs += '</div>';
            itembarangs += '</td>';


            // harga_pcs 
            itembarangs += '<td>';
            itembarangs += '<div class="form-group">'
            itembarangs += '<input type="text" class="form-control harga_pcs" readonly style="font-size:14px" id="harga_pcs-' +
                key +
                '" name="harga_pcs[]" value="' + harga_pcs + '" ';
            itembarangs += '</div>';
            itembarangs += '</td>';

            // harga_dus 
            itembarangs += '<td>';
            itembarangs += '<div class="form-group">'
            itembarangs += '<input type="text" class="form-control harga_dus" readonly style="font-size:14px" id="harga_dus-' +
                key +
                '" name="harga_dus[]" value="' + harga_dus + '" ';
            itembarangs += '</div>';
            itembarangs += '</td>';

            // satuan
            itembarangs += '<td>';
            itembarangs += '<div class="form-group">';
            itembarangs += '<select style="font-size:14px" class="form-control" id="satuan-' + key +
                '" name="satuan[]">';
            itembarangs += '<option value="">- Pilih Satuan -</option>';
            itembarangs += '<option value="pcs"' + (satuan === 'pcs' ? ' selected' : '') + '>pcs</option>';
            itembarangs += '<option value="dus"' + (satuan === 'dus' ? ' selected' : '') +
                '>dus</option>';
            itembarangs += '</select>';
            itembarangs += '</div>';
            itembarangs += '</td>';

            // jumlah 
            itembarangs += '<td>';
            itembarangs += '<div class="form-group">'
            itembarangs += '<input type="number" class="form-control jumlah" style="font-size:14px" id="jumlah-' +
                key +
                '" name="jumlah[]" value="' + jumlah + '" ';
            itembarangs += '</div>';
            itembarangs += '</td>';

            // total 
            itembarangs += '<td>';
            itembarangs += '<div class="form-group">'
            itembarangs += '<input type="text" class="form-control total" readonly style="font-size:14px" id="total-' +
                key +
                '" name="total[]" value="' + total + '" ';
            itembarangs += '</div>';
            itembarangs += '</td>';

            itembarangs += '<td style="width: 100px">';
            itembarangs += '<button type="button" class="btn btn-primary btn-sm" onclick="barang(' + key +
                ')">';
            itembarangs += '<i class="fas fa-plus"></i>';
            itembarangs += '</button>';
            itembarangs +=
                '<button style="margin-left:10px" type="button" class="btn btn-danger btn-sm" onclick="removeBarang(' +
                key + ')">';
            itembarangs += '<i class="fas fa-trash"></i>';
            itembarangs += '</button>';
            itembarangs += '</td>';
            itembarangs += '</tr>';

            $('#tabel-barang').append(itembarangs);
        }
    </script> --}}

@endsection
