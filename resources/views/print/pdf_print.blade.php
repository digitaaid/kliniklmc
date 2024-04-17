<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{-- @yield('title') --}}
    </title>
    <style>
        .unicode {
            font-family: "DejaVu Sans";
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .table {
            margin-bottom: 0px;
            border-collapse: collapse;
            width: 100%;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .table thead th {
            vertical-align: bottom;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid black !important;
            padding: 0;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black !important;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-borderless {
            border: 0px solid black !important;
            padding: 0;
        }

        .table-borderless th,
        .table-borderless td {
            border: 0px solid black !important;
            padding: 0;
        }

        pre {
            margin: 0;
            font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif;
        }

        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }
    </style>
    {{-- @yield('css') --}}
    {{-- @push('css') --}}
</head>

<body style="font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif">
    {{-- @yield('content') --}}
    <table class="table table-sm table-bordered" style="font-size: 4px">
        <tr>
            <td width="10%">
            </td>
            <td width="50%">
                <b>PEMERINTAHAN KABUPATEN CIREBON</b><br>
                <b>RUMAH SAKIT UMUM DAERAH WALED</b><br>
                Jl. Prabu Kian Santang No. 4 Kab. Cirebon Jawa Barat 45151
                www.rsudwaled.id - 0823 1169 6919 - (0231) 8850943
            </td>
            <td width="40%">
                {{-- <table class="table-borderless">
                        <tr>
                            <td>No RM</td>
                            <td>:</td>
                            <td><b>{{ $pasien->no_rm }}</b></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><b>{{ $pasien->nama_px }}</b></td>
                        </tr>
                        <tr>
                            <td>Tgl Lahir</td>
                            <td>:</td>
                            <td>
                                <b>{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('d, F Y') }}
                                    ({{ \Carbon\Carbon::parse($pasien->tgl_lahir)->diffInYears($kunjungan->tgl_masuk) }}
                                    tahun)</b>
                            </td>
                        </tr>
                        <tr>
                            <td>Kelamin</td>
                            <td>:</td>
                            <td>
                                <b>{{ $pasien->jenis_kelamin }}</b>
                            </td>
                        </tr>
                    </table> --}}
            </td>
        </tr>
    </table>
</body>

</html>
