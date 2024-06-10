<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Peminjaman</title>
    <style>
        body {
            padding: 0px;
            font-size: 14px;
        }

        .logo {
            width: 72px;
            z-index: 500;
            position: fixed;
        }

        .header {
            font-weight: bold;
            font-size: 16px;
        }

        .header-sm {
            font-size: 14px;
        }

        .table-1 .td-1 {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
            vertical-align: top;
        }

        * {
            font-family: 'Times New Roman', Times, serif;
            /* border: 1px solid black; */
        }

        .text-center {
            text-align: center
        }

        .text-header {
            font-size: 18px;
            font-weight: 500;
        }

        .layout-ttd {
            display: inline-flex;
            text-align: center;
        }

        .text-muted {
            font-size: 12px;
            opacity: 80%;
        }
    </style>
</head>

<body>
    <h3>Laporan Riva Jaya</h3>
    <table style="width: 100%;" class="table-1" cellspacing="0" cellpadding="10">
        <tr>
            <td class="td-1" width="120px">Kode Laporan</td>
            <td class="td-1" width="20px" style="text-align: center">:</td>
            <td class="td-1">
                {{ $laporan->kode_laporan }}
            </td>
        </tr>
        <tr>
            <td class="td-1" width="120px">Pembuat</td>
            <td class="td-1" width="20px" style="text-align: center">:</td>
            <td class="td-1">
                {{ $laporan->user->nama }}
            </td>
        </tr>
        <tr>
            <td class="td-1" width="120px">Tanggal Dibuat</td>
            <td class="td-1" width="20px" style="text-align: center">:</td>
            <td class="td-1">
                {{ $laporan->tanggal_awal }}
            </td>
        </tr>
        <tr>
            <td class="td-1" colspan="3">
                <u>Isi Laporan</u>
                <br>
                {!! $laporan->keterangan !!}
            </td>
        </tr>
    </table>
</body>

</html>
