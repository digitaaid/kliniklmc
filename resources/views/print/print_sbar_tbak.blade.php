@extends('adminlte::printer')
@section('title', 'Print Asesmen Keperawatan Rawat Jalan')
@section('content_header')
    <h1>Print Asesmen Keperawatan Rawat Jalan</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="printMe">
                <section>
                    <div class="col-md-12" style="font-size: 12px">
                        <div class="row">
                            @include('form.assesmen_kop')
                            <div class="col-md-12 border border-dark text-center">
                                <b class="">LEMBAR KOMUNIKASI EFEKTIF SBAR TBAK</b>
                            </div>
                            <div class="col-md-6 border border-dark">
                                <b>SBAR</b>
                            </div>
                            <div class="col-md-6  border border-dark">
                                <b>TBAK</b>
                            </div>
                            <div class="col-md-6 border border-dark">
                                <b>S (SITUATION) :</b><br>
                                <pre>{{ $sbar->situation }}</pre>
                            </div>
                            <div class="col-md-6  border border-dark">
                                <b>T (TULIS) :</b><br>
                                <pre>{{ $sbar->tulis }}</pre>
                            </div>
                            <div class="col-md-6 border border-dark">
                                <b>B (BACKGROUND) :</b><br>
                                <pre>{{ $sbar->background }}</pre>
                            </div>
                            <div class="col-md-6  border border-dark">
                                <b>BA (BACA) :</b><br>
                                <pre>{{ $sbar->baca }}</pre>
                            </div>
                            <div class="col-md-6 border border-dark">
                                <b>A (ASSESSMENT) :</b><br>
                                <pre>{{ $sbar->assessment }}</pre>
                            </div>
                            <div class="col-md-6  border border-dark">
                                <b>K (KONFIRMASI) :</b><br>
                                <pre>{{ $sbar->konfirmasi }}</pre>
                            </div>
                            <div class="col-md-6 border border-dark">
                                <b>R (RECOMENDATION) :</b><br>
                                <pre>{{ $sbar->recomendation }}</pre>
                            </div>
                            <div class="col-md-6 border border-dark">
                            </div>
                            <div class="col-md-6 border border-dark text-center">
                                <b>SBAR</b><br>
                                {!! QrCode::size(70)->generate('Telah dikomunikasikan SBAR pada waktu ' . $sbar->waktu_sbar) !!} <br>
                                <b><u>{{ $sbar->pengirim }}</u></b><br>
                                Waktu : {{ $sbar->waktu_sbar }}
                            </div>
                            <div class="col-md-6  border border-dark text-center">
                                <b>TBAK</b> <br>
                                {!! QrCode::size(70)->generate('Telah dikomunikasikan TBAK pada waktu ' . $sbar->waktu_tbak) !!} <br>
                                <b><u>{{ $sbar->penerima }}</u></b> <br>
                                Waktu : {{ $sbar->waktu_tbak }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Select2', true)
@section('css')
    <style>
        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            font-size: 11px !important;
        }
    </style>
    <style type="text/css" media="print">
        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }

        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            font-size: 11px !important;
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
        // $(document).ready(function() {
        //     window.print();
        // });
        // setTimeout(function() {
        //     window.top.close();
        // }, 2000);
    </script>
@endsection
