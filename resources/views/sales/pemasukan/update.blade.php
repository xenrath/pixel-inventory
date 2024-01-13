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
                    </div>
                    <div>
                        <div class="card" id="form_biayatambahan">
                            <div class="card-header">
                                <h3 class="card-title">Barang <span>
                                    </span></h3>
                                <div class="float-right">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addBarang()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="font-size:14px" class="text-center">No</th>
                                            <th style="font-size:14px">Kode Barang</th>
                                            <th style="font-size:14px">Nama Barang</th>
                                            <th style="font-size:14px">Harga pcs</th>
                                            <th style="font-size:14px">Harga dus</th>
                                            <th style="font-size:14px">Satuan</th>
                                            <th style="font-size:14px">Jumlah</th>
                                            <th style="font-size:14px">Total</th>
                                            <th style="font-size:14px">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-barang">
                                        @foreach ($details as $detail)
                                            <tr id="barang-{{ $loop->index }}">
                                                <td style="width: 70px; font-size:14px" class="text-center"
                                                    id="urutanbarang">{{ $loop->index + 1 }}
                                                </td>
                                                <div class="form-group" hidden>
                                                    <input type="text" class="form-control"
                                                        id="detail_ids-{{ $loop->index }}" name="detail_ids[]"
                                                        value="{{ $detail['id'] }}">
                                                </div>
                                                <td>
                                                    <div class="form-group"hidden>
                                                        <input style="font-size:14px" type="text" class="form-control"
                                                            id="barang_id-{{ $loop->index }}" name="barang_id[]"
                                                            value="{{ $detail['barang_id'] }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" readonly type="text"
                                                            class="form-control" id="kode_barang-{{ $loop->index }}"
                                                            name="kode_barang[]" value="{{ $detail['kode_barang'] }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" readonly type="text"
                                                            class="form-control" id="nama_barang-{{ $loop->index }}"
                                                            name="nama_barang[]" value="{{ $detail['nama_barang'] }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text"
                                                            class="form-control harga_pcs" readonly
                                                            id="harga_pcs-{{ $loop->index }}" name="harga_pcs[]"
                                                            value="{{ number_format($detail['harga_pcs'], 0, ',', '.') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text"
                                                            class="form-control harga_dus" readonly
                                                            id="harga_dus-{{ $loop->index }}" name="harga_dus[]"
                                                            value="{{ number_format($detail['harga_dus'], 0, ',', '.') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <select class="form-control" style="font-size:14px"
                                                            id="satuan-{{ $loop->index }}" name="satuan[]">
                                                            <option value="">- Pilih Satuan -</option>
                                                            <option value="pcs"
                                                                {{ old('satuan', $detail['satuan']) == 'pcs' ? 'selected' : null }}>
                                                                pcs</option>
                                                            <option value="dus"
                                                                {{ old('satuan', $detail['satuan']) == 'dus' ? 'selected' : null }}>
                                                                dus</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="number" class="form-control jumlah"
                                                            id="jumlah-{{ $loop->index }}" name="jumlah[]"
                                                            value="{{ $detail['jumlah'] }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control total" id="total-{{ $loop->index }}"
                                                            name="total[]" value="{{ number_format($detail['total'], 0, ',', '.') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 100px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="barang({{ $loop->index }})">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button style="margin-left:5px" type="button"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="removeBarang({{ $loop->index }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group mt-3">
                                    <label style="font-size:14px" for="grand_total">Grand Total</label>
                                    <input style="text-align: end; margin:right:10px; font-size:14px;" type="text"
                                        class="form-control grand_total" id="grand_total" name="grand_total"
                                        placeholder="" value="{{ old('grand_total', $pemasukan->grand_total) }}">
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
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

        <div class="modal fade" id="tableBarang" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Barang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables66" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                    <th>Harga pcs</th>
                                    <th>Harga dus</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                    <tr data-id="{{ $barang->id }}" data-kode_barang="{{ $barang->kode_barang }}"
                                        data-nama_barang="{{ $barang->nama_barang }}"
                                        data-harga_pcs="{{ $barang->harga_pcs }}"
                                        data-harga_dus="{{ $barang->harga_dus }}" data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $barang->kode_barang }}</td>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>{{ $barang->jumlah }}</td>
                                        <td> {{ number_format($barang->harga_pcs, 0, ',', '.') }}
                                        </td>
                                        <td> {{ number_format($barang->harga_dus, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getBarang({{ $loop->index }})">
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
    </script>

    <script>
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
    </script>

    <script>
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
            //     url: "{{ url('sales/detail_pemasukan/') }}/" + detailId,
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
    </script>

@endsection
