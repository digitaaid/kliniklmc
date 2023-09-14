<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Assesment Rawat Jalan</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black !important;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="col">
                    <img src="{{ asset('logo3.png') }}" alt="" width="100px">
                </th>
                <th scope="col">
                    Rumah Sakit Umum Daerah <br>
                    Waled Kabupaten Cirebon
                </th>
                <th scope="col">
                    No RM : 00000000<br>
                    Nama : Marwan Dhiaur Rahman<br>
                    Tanggal Lahir : Cirebon 9 Mei 1998<br>
                    Gender : L<br>
                </th>
            </tr>
            <tr class="table-warning text-center">
                <td colspan="3">
                    <b>
                        FORMULIR UMUM / ASSESMENT RAWAT JALAN
                    </b>
                </td>
            </tr>
            <tr style="font-size: 10">
                <td colspan="2" width="50%" scope="row">
                    <u><b>ANAMNESA</b></u>
                    <dl>
                        <dt>Keluhan Utama :</dt>
                        <dd>A description list is perfect for defining terms.</dd>
                        <dt>Riwayat Penyakit :</dt>
                        <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>
                        <dt>Riwayat Alergi :</dt>
                        <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                        <dt>Riwayat Pengobatan :</dt>
                        <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                    </dl>
                </td>
                <td width="50%">
                    <u><b>PEMERIKSAAN FISIK</b></u>
                    <br>
                    <b>Denyut Jantung : </b> 30 spm <br>
                    <b>Pernapasan : </b> 30 spm <br>
                    <b>Tekanan Darah : </b> 30 spm <br>
                    <b>Suhu Tubuh : </b> 30 spm <br><br>
                    <dl>
                        <dt>Tingkat Kesadaran :</dt>
                        <dd>A description list is perfect for defining terms.</dd>
                        <dt>Tanda Vital Tubuh</dt>
                        <dd>A description list is perfect for defining terms.</dd>
                    </dl>
                </td>
            </tr>
            <tr style="font-size: 10">
                <td colspan="2" width="50%" scope="row">
                    <u><b>PEMERIKSAAN PSIKOLOGI</b></u>
                    <dl>
                        <dt>Kondisi Psikologis :</dt>
                        <dd>A description list is perfect for defining terms.</dd>
                        <dt>Kondisi Sosial Ekonomi :</dt>
                        <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>
                        <dt>Kondisi Spiritual :</dt>
                        <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                    </dl>
                </td>
                <td width="50%">
                    <u><b>CATATAN</b></u>
                </td>
            </tr>
        </tbody>
    </table>
    @if ($request->printer != 1)
        <form action="" method="GET">
            <input type="hidden" name="printer" value="1">
            <button class="btn btn-primary"> Print</button>
        </form>
    @endif
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
</body>

</html>
