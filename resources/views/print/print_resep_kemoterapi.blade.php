@extends('adminlte::print')
@section('title', 'Print Asesmen Resep Obat')
@section('content_header')
    <h1>Print Asesmen Resep Obat</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="printMe">
                <section class="invoice p-3 mb-1">
                    <div class="row">
                        <img src="{{ asset('medicio/assets/img/lmc.png') }}" style="height: 70px">
                        <div class="col text-center">
                            <b>KLINIK UTAMA LUTHFI MEDICAL CENTER</b><br>
                            Jl. Raya Sunan Gunung Jati No. 100 A/B Desa Pasindangan Kec. Gunungjati Kab. Cirebon Jawa Barat
                            45151<br>
                            www.luthfimedicalcenter.com - Whatasapp 0823 1169 6919 - Call Center (0231) 8850943
                        </div>
                        <hr width="100%" hight="30px" class="m-1 " color="black" size="50px" />
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col text-center">
                            <b class="text-md">PERMINTAAN OBAT KEMOTERAPI</b> <br>
                        </div>
                        <div class="col-sm-6 invoice-col">
                            <dl class="row">
                                <dt class="col-sm-4 m-0">Tgl Pelayanan</dt>
                                <dd class="col-sm-8 m-0">{{ $resep->waktu }}</b></dd>
                                <dt class="col-sm-4 m-0">Nama Pasien</dt>
                                <dd class="col-sm-8 m-0">{{ $resep->nama }}</b></dd>
                                <dt class="col-sm-4 m-0">No RM</dt>
                                <dd class="col-sm-8 m-0">{{ $resep->norm }}</b></dd>
                                <dt class="col-sm-4 m-0">Diagnosa</dt>
                                <dd class="col-sm-8 m-0">{{ $resep->diagnosa }}</b></dd>
                                <dt class="col-sm-4 m-0">Regimen</dt>
                                <dd class="col-sm-8 m-0">{{ $resep->regimen }}</b></dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-6 invoice-col">
                            <h6>Obat Kemoterapi</h6>
                            <table class="table table-sm text-xs">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Obat</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resep->resepdetail->where('obat.jenisobat', 'Obat Kemoterapi') as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6 invoice-col">
                            <h6>Penunjang Kemoterapi</h6>
                            <table class="table table-sm text-xs">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Obat</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resep->resepdetail->where('obat.jenisobat', 'Penunjang Kemoterapi') as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6 mt-1">
                            <b> Dokter DPJP,</b>
                            <br><br><br><br>
                            <b><u> dr. Mohamad Luthfi, SpPD., KHOM., FINASIM., MMRS.</u></b>

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

        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            font-size: 15px;
        }

        #resepobat {
            font-size: 22px !important;
            border: none;
            outline: none;
            padding: 0 !important;
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
            border: 1px solid #000000 !important;
            font-size: 10px !important;
            padding: 2px !important;
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
