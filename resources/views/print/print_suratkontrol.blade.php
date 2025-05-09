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
                    @include('print.print_kop')
                    <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col text-center">
                            <b class="text-md">SURAT KONTROL RAWAT JALAN</b> <br>
                            <b class="text-md">No. {{ $suratkontrol->noSuratKontrol }}</b>
                            <br>
                            <br>
                        </div>
                        <div class="col-sm-6 invoice-col">
                            <dl class="row">
                                <dt class="col-sm-4 m-0">Nama Pasien</dt>
                                <dd class="col-sm-8 m-0">{{ $peserta->nama }}</dd>
                                <dt class="col-sm-4 m-0">Nomor Kartu</dt>
                                <dd class="col-sm-8 m-0">{{ $peserta->noKartu }}</dd>
                                <dt class="col-sm-4 m-0">No HP / Telp</dt>
                                <dd class="col-sm-8 m-0"></dd>
                                <dt class="col-sm-4 m-0">Jenis Kelamin</dt>
                                <dd class="col-sm-8 m-0">{{ $peserta->kelamin }}</dd>
                                <dt class="col-sm-4 m-0">Tanggal Lahir</dt>
                                <dd class="col-sm-8 m-0">{{ $peserta->tglLahir }}</dd>

                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4 m-0">Tanggal Kontrol</dt>
                                <dd class="col-sm-8 m-0">{{ $suratkontrol->tglRencanaKontrol }}</b></dd>
                                <dt class="col-sm-4 m-0">Tanggal Terbit</dt>
                                <dd class="col-sm-8 m-0">{{ $suratkontrol->tglTerbit }}</b></dd>
                                <dt class="col-sm-4 m-0">Jenis Kontrol</dt>
                                <dd class="col-sm-8 m-0">{{ $suratkontrol->namaJnsKontrol }}</b></dd>
                                <dt class="col-sm-4 m-0">Poliklinik Tujuan</dt>
                                <dd class="col-sm-8 m-0">{{ $suratkontrol->namaPoliTujuan }}</b></dd>
                                <dt class="col-sm-4 m-0">Dokter</dt>
                                <dd class="col-sm-8 m-0">{{ $suratkontrol->namaDokter }}</b></dd>
                            </dl>
                        </div>
                        <div class="col-sm-6 invoice-col">
                            <dl class="row">
                                <dt class="col-sm-4 m-0">No SEP</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->noSep }}</b></dd>
                                <dt class="col-sm-4 m-0">Tanggal SEP</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->tglSep }}</b></dd>
                                <dt class="col-sm-4 m-0">Jenis Pelayanan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->jnsPelayanan }}</b></dd>
                                <dt class="col-sm-4 m-0">Poliklinik</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->poli }}</b></dd>
                                <dt class="col-sm-4 m-0">Diagnosa</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->diagnosa }}</b></dd>
                                <dt class="col-sm-4 m-0">Prov. Perujuk</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->provPerujuk->nmProviderPerujuk }}</b></dd>
                                <dt class="col-sm-4 m-0">Asal Rujukan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->provPerujuk->asalRujukan }}</b></dd>
                                <dt class="col-sm-4 m-0">No Rujukan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->provPerujuk->noRujukan }}</b></dd>
                                <dt class="col-sm-4 m-0">Tanggal Rujukan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->provPerujuk->tglRujukan }}</b></dd>
                            </dl>
                        </div>
                        <div class="col-sm-12 ">
                            Dengan ini pasien diatas belum dapat dikembalikan ke Fasilitas Kesehatan Perujuk. Rencana tindak
                            lanjut akan dilanjutkan pada kunjungan selanjutnya.
                            Surat Keterangan ini hanya dapat digunakan 1 (satu) kali pada kunjungan dengan diagnosa diatas.
                        </div>
                        <br>
                        <div class="col-sm-8 mt-1">
                        </div>
                        <div class="col-sm-4 mt-1">
                            <b> Cirebon, {{ Carbon\Carbon::now()->translatedFormat('d F Y') }} <br>
                                DPJP,</b>

                            <br><br><br><br>
                            <b><u>{{ $dokter->namadokter }}</u></b>
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
