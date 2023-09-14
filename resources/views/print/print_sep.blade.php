@extends('adminlte::print')
@section('title', 'SEP ' . $sep->noSep)
@section('content_header')
    <h1>SEP {{ $sep->noSep }}</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="printMe">
                <section class="invoice p-3 mb-1">
                    <div class="row">
                        <img src="{{ asset('img/bpjs.png') }}" style="height: 70px">
                        <div class="col text-center">
                            <b>RUMAH SAKIT UMUM DAERAH WALED KABUPATEN CIREBON</b><br>
                            Jalan Raden Walangsungsang Kecamatan Waled Kabupaten Cirebon 45188<br>
                            www.rsudwaled.id - brsud.waled@gmail.com - Whatasapp 0895 4000 60700 - Call Center (0231) 661126
                        </div>
                        <img src="{{ asset('medicio/assets/img/lmc.png') }}" style="height: 70px">
                        <hr width="100%" hight="30px" class="m-1 " color="black" size="50px" />
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col text-center">
                            <b class="text-md">SURAT ELEGTABILITAS PASIEN (SEP)</b> <br>
                            <b class="text-md">No. {{ $sep->noSep }}</b>
                            <br>
                            <br>
                        </div>
                        <div class="col-sm-6 invoice-col">
                            <dl class="row">
                                <dt class="col-sm-4 m-0">No SEP</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->noSep }}</b></dd>
                                <dt class="col-sm-4 m-0">Tgl SEP</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->tglSep }}</b></dd>
                                <dt class="col-sm-4 m-0">Nomor Kartu</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->peserta->noKartu }}</b></dd>
                                <dt class="col-sm-4 m-0">Nomor RM</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->peserta->noMr }}</b></dd>
                                <dt class="col-sm-4 m-0">Nama</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->peserta->nama }}</b></dd>
                                <dt class="col-sm-4 m-0">Tanggal Lahir</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->peserta->tglLahir }}</b></dd>
                                <dt class="col-sm-4 m-0">Jenis Kelamin</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->peserta->kelamin }}</b></dd>
                                <dt class="col-sm-4 m-0">Jenis Peserta</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->peserta->jnsPeserta }}</b></dd>
                            </dl>
                        </div>
                        <div class="col-sm-6 invoice-col">
                            <dl class="row">
                                <dt class="col-sm-4 m-0">No Rujukan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->noRujukan }}</b></dd>
                                <dt class="col-sm-4 m-0">No Surat Kontrol</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->kontrol->noSurat }}</b></dd>
                                <dt class="col-sm-4 m-0">Jenis Pelayanan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->jnsPelayanan }}</b></dd>
                                <dt class="col-sm-4 m-0">Kelas Rawat</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->kelasRawat }}</b></dd>
                                <dt class="col-sm-4 m-0">Poli Tujuan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->poli }}</b></dd>
                                <dt class="col-sm-4 m-0">DPJP</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->dpjp->nmDPJP }}</b></dd>
                                <dt class="col-sm-4 m-0">Diagnosa Awal</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->diagnosa }}</b></dd>
                                <dt class="col-sm-4 m-0">Catatan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->catatan }}</b></dd>
                            </dl>
                        </div>
                        <div class="col-sm-8 mt-1">
                            <i>*Saya Menyetujui BPJS Kesehatan menggunakan Informasi Medis Pasien jika diperlukan</i><br>
                            <i>*SEP bukan sebagai bukti penjaminan peserta</i><br>
                            <p>Waktu Cetak : {{ now() }}</p><br>
                        </div>
                        <div class="col-sm-2 mt-1">
                            <b> Pasien/<br>
                                Keluarga Pasien
                            </b>
                            <br><br><br><br>
                            <hr>
                        </div>
                        <div class="col-sm-2 mt-1">
                            <b> Petugas<br>
                                BPJS Kesehatan
                            </b>
                            <br><br><br><br>
                            <hr>
                        </div>
                    </div>
                </section>
            </div>
            <button class="btn btn-success btnPrint" onclick="printDiv('printMe')"><i class="fas fa-print"> Print
                    Laporan</i>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Select2', true)
@section('css')
    <style type="text/css" media="print">
        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }

        .main-footer {
            display: none !important;
        }

        .btnPrint {
            display: none !important;
        }
    </style>
@endsection
@section('js')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            tampilan_print = document.body.innerHTML = printContents;
            setTimeout('window.addEventListener("load", window.print());', 1000);
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            window.print();
        });
        setTimeout(function() {
            window.top.close();
        }, 2000);
    </script>
@endsection
