@extends('adminlte::print')
@section('title', 'Hasil Lab LMC ' . $permintaan->nama)
@section('content_header')
    <h1>Hasil Lab LMC {{ $permintaan->nama }}</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="printMe">
                <section class="invoice p-3 mb-1">
                    <div class="row">
                        <div class="col-md-4">
                            <h4>LABORATORIUM</h4>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <img src="{{ asset('medicio/assets/img/lmc.png') }}" style="height: 70px">
                        </div>
                        <div class="col-md-8">
                            <div class="col text-center">
                                <b>KLINIK UTAMA LUTHFI MEDICAL CENTER</b><br>
                                Jl. Raya Sunan Gunung Jati No. 100 A/B Desa Pasindangan Kec. Gunungjati Kab. Cirebon Jawa Barat
                                45151<br>
                                www.luthfimedicalcenter.com - Whatasapp 0823 1169 6919 - Call Center (0231) 8850943
                            </div>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4 m-0">Nama</dt>
                                <dd class="col-sm-8 m-0">: {{ $permintaan->nama }} </dd>
                                <dt class="col-sm-4 m-0">No RM</dt>
                                <dd class="col-sm-8 m-0">: {{ $permintaan->norm }} </dd>
                                <dt class="col-sm-4 m-0">Tgl. Lahir</dt>
                                <dd class="col-sm-8 m-0">: {{ $permintaan->pasien->tgl_lahir ?? '-' }} </dd>
                                <dt class="col-sm-4 m-0">Jenis Kelamin</dt>
                                <dd class="col-sm-8 m-0">: {{ $permintaan->pasien->gender ?? '-' }} </dd>
                                <dt class="col-sm-4 m-0">Diagnosa</dt>
                                <dd class="col-sm-8 m-0">: {{ $permintaan->diagnosa }} </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4 m-0">Dokter</dt>
                                <dd class="col-sm-8 m-0">: {{ $permintaan->dpjp }} </dd>
                                <dt class="col-sm-4 m-0">Alamat</dt>
                                <dd class="col-sm-8 m-0">: Klinik LMC </dd>
                                <dt class="col-sm-4 m-0">Tgl Pemeriksaan</dt>
                                <dd class="col-sm-8 m-0">: {{ $permintaan->waktu }} </dd>
                            </dl>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-sm  table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Pemeriksaan</th>
                                        <th colspan="2">Hasil</th>
                                        <th>Nilai Rujukan</th>
                                        <th>Satuan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $key = 0;
                                    @endphp
                                    @foreach ($pemeriksaan as $prksa)
                                        <tr>
                                            <td><b>{{ $prksa->nama }}</b></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @foreach ($prksa->parameters as $param)
                                            <tr>
                                                <input type="hidden" name="parameter_id[]" value="{{ $param->id }}">
                                                <td>&emsp;&emsp;{{ $param->nama }}</td>
                                                <td>{{ $hasillab->hasil[$key] ?? '-' }}</td>
                                                <th>*&emsp;&emsp;</th>
                                                <td>{{ $param->nilai_rujukan }}</td>
                                                <td>{{ $param->satuan }}</td>
                                                <td>{{ $hasillab->keterangan[$key] ?? '-' }}
                                                </td>
                                            </tr>
                                            @php
                                                $key++;
                                            @endphp
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-8 mt-1">
                            <dl>
                                <dt>Catatan :</dt>
                                <dd>{{ $permintaan->catatan }} </dd>
                            </dl>
                        </div>
                        <div class="col-sm-2 mt-1">
                            <b>Pemeriksa,</b>
                            <br><br><br>
                            <hr>
                        </div>
                        <div class="col-sm-2 mt-1">
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

        table,
        th,
        td {
            padding: 0px !important;
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
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

        table,
        th,
        td {
            padding: 0px !important;
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
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
