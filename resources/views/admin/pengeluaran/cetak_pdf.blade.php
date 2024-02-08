<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengeluaran Barang</title>
    <style>
        .b {
            border: 1px solid black;
        }

        .table,
        .td {
            /* border: 1px solid black; */
        }

        .table,
        .tdd {
            border: 1px solid white;
        }

        html,
        body {
            font-family: 'DOSVGA', monospace;
            /* font-family: 'Arial', sans-serif; */
            color: black;
        }

        span.h2 {
            font-size: 24px;
            /* font-weight: 500; */
        }

        .label {
            font-size: 16px;
            text-align: center;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tdd td {
            border: none;
        }

        .container {
            position: relative;
            margin-top: 7rem;
        }

        .faktur {
            text-align: center
        }

        .info-container {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 16px;
            margin: 5px 0;
        }

        .right-col {
            text-align: right;
        }

        .info-text {
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .info-left {
            text-align: left;
        }

        .info-item {
            flex: 1;
        }

        .alamat {
            color: black;
            font-weight: bold;
        }

        .blue-button:hover {
            background-color: #0056b3;
        }

        .alamat,
        .nama-pt {
            color: black;
            font-weight: bold;
        }

        .label {
            color: black;
        }


        .info-catatan {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 2px;
        }

        .info-catatan2 {
            font-weight: bold;
            margin-right: 5px;
            min-width: 120px;
        }

        .tdd1 td {
            text-align: center;
            font-size: 15px;
            position: relative;
            padding-top: 10px;
        }

        .tdd1 td::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            border-top: 1px solid black;
        }

        .info-1 {}

        .label {
            font-size: 15px;
            text-align: center;

        }

        .separator {
            padding-top: 15px;
            text-align: center;

        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
        }

        @page {
            /* size: A4; */
            margin: 1cm;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    {{-- <div id="logo-container">
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="Riva Jaya" width="100" height="50">
    </div> --}}
    <br>
    <table cellpadding="2" cellspacing="0">
        <tr>
            <td class="info-catatan2" style="font-size: 15px;">Riva Jaya Abadi</td>
            <td class="info-catatan2" style="font-size: 15px; margin-left: 40px; display: block;">Nama Supplier</td>
            <td style="text-align: left; font-size: 15px;">
                <span class="content2">
                    @if ($pengeluaran->supplier)
                        {{ $pengeluaran->supplier->nama_supp }}
                    @else
                        tidak ada
                    @endif
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 15px;">Jl. Pojosumarto 2
                {{-- <br>
                SLAWI TEGAL <br>
                Telp/ Fax 02836195326 02836195187 --}}
            </td>
            </td>
            <td class="info-catatan2" style="font-size: 15px; margin-left: 40px; display: block;">Alamat</td>
            <td style="text-align: left; font-size: 15px;">
                <span class="content2">
                    @if ($pengeluaran->supplier)
                        {{ $pengeluaran->supplier->alamat }}
                    @else
                        tidak ada
                    @endif
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 15px;">Talang, Tegal
            </td>
            <td class="info-catatan2" style="font-size: 15px; margin-left: 40px; display: block;">Telp / Hp</td>
            <td style="text-align: left; font-size: 15px;">
                <span class="content2">
                    @if ($pengeluaran->supplier)
                        {{ $pengeluaran->supplier->telp }}
                    @else
                        tidak ada
                    @endif
                    /
                    @if ($pengeluaran->supplier)
                        {{ $pengeluaran->supplier->hp }}
                    @else
                        tidak ada
                    @endif
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 15px;">Telp 081568445462
            </td>
            <td class="info-catatan2" style="font-size: 15px; margin-left: 40px; display: block;">ID Supplier</td>

            <td style="text-align: left; font-size: 15px;">
                <span class="content2">
                    @if ($pengeluaran->supplier)
                        {{ $pengeluaran->supplier->kode_supplier }}
                    @else
                        tidak ada
                    @endif

                </span>
                <br>
            </td>
        </tr>
    </table>

    <br>
    <div style="font-weight: bold; text-align: center;">
        <span style="font-weight: bold; font-size: 20px;">PENGELUARAN BARANG</span>
        <br>
    </div>
    <table style="width: 100%;
                    border-top: 1px solid black; margin-bottom:5px">
        <tr>
            <td>
                <span class="info-item" style="font-size: 15px; padding-left: 5px;">No. Faktur:
                    {{ $pengeluaran->kode_pengeluaran }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 15px;">Tanggal:{{ $pengeluaran->tanggal }}</span>
                <br>
            </td>
        </tr>
    </table>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; font-size: 15px;">No.</td>
            <td class="td" style="font-size: 15px;">Nama Barang</td>
            <td class="td" style="font-size: 15px;">Harga</td>
            <td class="td" style="font-size: 15px;">Jumlah</td>
            <td class="td" style="text-align: center; font-size: 15px;">Total</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;"></td>
        </tr>
        @php
            $totalQuantity = 0;
            $totalHarga = 0;
        @endphp
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center; font-size: 15px;">{{ $loop->iteration }}
                </td>
                <td class="info-text info-left" style="font-size: 15px; ">
                    {{ $item->nama_barang }}
                </td>
                <td class="td" style="font-size: 15px;">
                    @if ($item->satuan == 'pcs')
                        @harga($item->harga_pcs)
                    @elseif($item->satuan == 'dus')
                        @harga($item->harga_dus)
                    @elseif($item->satuan == 'renceng')
                        @harga($item->harga_renceng)
                    @elseif($item->satuan == 'pack')
                        @harga($item->harga_pack)
                    @endif
                </td>
                <td class="td" style="font-size: 15px;">
                    {{ $item->jumlah }} {{ ucfirst($item->satuan) }}
                </td>
                <td class="td" style="text-align: right; font-size: 15px;">
                    @harga($item->total)
                </td>
            </tr>
            @php
                $totalQuantity += 1;
                $totalHarga += $item->total;
            @endphp
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td colspan="4"
                style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 15px;">
                Sub Total
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 15px;">
                @rupiah($pengeluaran->grand_total)
            </td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td>
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 15px;">Nama Bank</td>
                            <td class="info-item" style="font-size: 15px;">:</td>
                            <td class="info-text info-left" style="font-size: 15px;">
                                @if ($pengeluaran->supplier)
                                    {{ $pengeluaran->supplier->nama_bank }}
                                @else
                                    tidak ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 15px;">No. Rekening</td>
                            <td class="info-item" style="font-size: 15px;">:</td>
                            <td class="info-text info-left" style="font-size: 15px;">
                                @if ($pengeluaran->supplier)
                                    {{ $pengeluaran->supplier->norek }}
                                @else
                                    tidak ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 15px;">Atas Nama</td>
                            <td class="info-item" style="font-size: 15px;">:</td>
                            <td class="info-text info-left" style="font-size: 15px;">
                                @if ($pengeluaran->supplier)
                                    {{ $pengeluaran->supplier->atas_nama }}
                                @else
                                    tidak ada
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">{{ auth()->user()->nama }}</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Admin</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">
                            @if ($pengeluaran->user)
                                {{ $pengeluaran->user->nama }}
                            @else
                                user tidak ada
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Sales</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label" style="min-height: 16px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Owner</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label" style="min-height: 16px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Supplier</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
