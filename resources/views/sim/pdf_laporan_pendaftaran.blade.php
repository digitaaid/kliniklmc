<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendaftaran</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>
<style type="text/css">
    table,
    th,
    td {
        border: 1px solid #000000 !important;
        font-size: 10px !important;
        padding: 2px !important;
    }

    hr {
        color: #333333 !important;
        border: 1px solid #333333 !important;
        line-height: 1.5;
    }
</style>
<body>
    <div>
        <div class="m-1 text-center" style="width: 15%; float: left;">
            <img src="{{ asset('img/bpjs.png') }}" style="height: 50px">
        </div>
        <div style="width: 70%; float: left; ">
            <div class="col text-center">
                <b>KLINIK UTAMA LUTHFI MEDICAL CENTER</b><br>
                <div style="font-size: 7">
                    Jl. Raya Sunan Gunung Jati No. 100 A/B Desa Pasindangan Kec. Gunungjati Kab. Cirebon Jawa Barat
                    45151<br>
                    www.luthfimedicalcenter.com - Whatasapp 0823 1169 6919 - Call Center (0231) 8850943
                </div>
            </div>
        </div>
        <div class="m-1 text-center" style="width: 15%; float: left;" >
            <img src="{{ asset('medicio/assets/img/lmc.png') }}" style="height: 50px">
        </div>
        <div style="clear: both;"></div>
        <hr class="m-0 mb-2">
    </div>
    <div class="row">
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No RM</th>
                    <th>Nama Pasien</th>
                    <th>No BPJS</th>
                    <th>Asal Perujuk</th>
                    <th>Jenis Pasien</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($antrians->where('taskid', 7) as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->tanggalperiksa }}</td>
                        <td>{{ $item->norm }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->nomorkartu }}</td>
                        <td>{{ $item->perujuk }}</td>
                        <td>{{ $item->jenispasien }} </td>
                        <td>Selesai</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
