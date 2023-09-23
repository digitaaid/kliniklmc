@extends('adminlte::print')
@section('title', 'Asesmen Resep Obat')
@section('content_header')
    <h1>Asesmen Resep Obat</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="printMe">
                <section class="invoice p-3 mb-1">
                    <div class="row">
                        <div class="col-md-2 border border-dark">
                            <div class="m-2  text-center">
                                <img class="" src="{{ asset('medicio/assets/img/lmc.png') }}" style="height: 80px">
                            </div>
                        </div>
                        <div class="col-md-6  border border-dark">
                            <b>KLINIK UTAMA LUTHFI MEDICAL CENTER</b><br>
                            Jl. Raya Sunan Gunung Jati No. 100 A/B <br>
                            Desa Pasindangan Kec. Gunungjati Kab. Cirebon Jawa Barat 45151<br>
                            www.luthfimedicalcenter.com - Call Center (0231) 8850943 / 0823 1169 6919
                        </div>
                        <div class="col-md-4  border border-dark">
                            <b>
                                No RM : {{ $kunjungan->norm }} <br>
                                Nama : {{ $kunjungan->nama }} <br>
                                Tgl Lahir : {{ $kunjungan->tgl_lahir }}
                                ({{ \Carbon\Carbon::parse($kunjungan->tgl_lahir)->diffInYears($kunjungan->tgl_masuk) }}
                                tahun) <br>
                                Kelamin : {{ $kunjungan->gender }}
                            </b>
                        </div>
                        <div class="col-md-8  border border-dark">
                            <dl>
                                <dt>Resep Obat :</dt>
                                @if ($antrian->resepobat)
                                    Kode Resep : {{ $antrian->resepobat->kode }} <br>
                                    Waktu : {{ $antrian->resepobat->waktu }} <br>
                                    @if ($antrian->resepobat)
                                        @foreach ($antrian->resepobat->resepdetail as $itemobat)
                                            <b> R/ {{ $itemobat->nama }} </b> ({{ $itemobat->jumlah }}) <br>
                                            &emsp;&emsp;
                                            @switch($itemobat->interval)
                                                @case('qod')
                                                    1x1
                                                @break

                                                @case('dod')
                                                    1x2
                                                @break

                                                @case('bid')
                                                    2x1
                                                @break

                                                @case('tid')
                                                    3x1
                                                @break

                                                @case('qid')
                                                    4x1
                                                @break

                                                @case('prn')
                                                    SESUAI KEBUTUHAN
                                                @break

                                                @case('q3h')
                                                    SETIAP 3 JAM
                                                @break

                                                @case('q4h')
                                                    SETIAP 4 JAM
                                                @break

                                                @default
                                            @endswitch


                                            @switch($itemobat->waktu)
                                                @case('pc')
                                                    SETELAH MAKAN
                                                @break

                                                @case('ac')
                                                    SEBELUM MAKAN
                                                @break

                                                @case('hs')
                                                    SEBELUM TIDUR
                                                @break

                                                @case('int')
                                                    DIANTARA WAKTU MAKAN
                                                @break

                                                @default
                                            @endswitch


                                            {{ $itemobat->keterangan }} <br>
                                        @endforeach
                                    @endif


                                @endif

                                <dd>
                                    <pre id="resepobat">{{ $antrian->asesmendokter->resep_obat ?? null }}</pre>
                                </dd>
                                <dt>Catatan Resep :</dt>
                                <dd>
                                    <pre>{{ $antrian->asesmendokter->catatan_resep ?? null }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-4 border border-dark">
                            <div class="row">
                                <div class="col-md-12 border border-dark">
                                    <b>Barat Badan</b> : {{ $antrian->asesmenperawat->berat_badan ?? '-' }} kg<br>
                                    <b>Tgl</b> : {{ $antrian->asesmendokter->waktu ?? '-' }}<br>
                                    <dl>
                                        <dt>Unit :</dt>
                                        <dd>
                                            {{ $antrian->namapoli ?? '-' }}
                                        </dd>
                                        <dt>Dokter :</dt>
                                        <dd>
                                            {{ $antrian->namadokter ?? '-' }}
                                        </dd>
                                        <dt>Riwayat Alergi Obat :</dt>
                                        <dd>
                                            <pre>{{ $antrian->asesmenperawat->riwayat_alergi ?? null }}</pre>
                                        </dd>
                                    </dl>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 border border-dark"><b>Penelaah Resep</b></div>
                                <div class="col-md-2 border border-dark">Ya</div>
                                <div class="col-md-2 border border-dark">Tidak</div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 border border-dark">1</div>
                                <div class="col-md-7 border border-dark">Identitas pasien, benar</div>
                                <div class="col-md-2 border border-dark"></div>
                                <div class="col-md-2 border border-dark"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 border border-dark">2</div>
                                <div class="col-md-7 border border-dark">Obat, benar</div>
                                <div class="col-md-2 border border-dark"></div>
                                <div class="col-md-2 border border-dark"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 border border-dark">3</div>
                                <div class="col-md-7 border border-dark">Dosis, benar</div>
                                <div class="col-md-2 border border-dark"></div>
                                <div class="col-md-2 border border-dark"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 border border-dark">4</div>
                                <div class="col-md-7 border border-dark">Waktu, & frekuensi pemberian obat, benar</div>
                                <div class="col-md-2 border border-dark"></div>
                                <div class="col-md-2 border border-dark"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 border border-dark">5</div>
                                <div class="col-md-7 border border-dark">Cara pemberian obat, benar</div>
                                <div class="col-md-2 border border-dark"></div>
                                <div class="col-md-2 border border-dark"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 border border-dark"><b>H (Harga)</b></div>
                                <div class="col-md-8 border border-dark"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 border border-dark"><b>R (Racik)</b></div>
                                <div class="col-md-8 border border-dark"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 border border-dark"><b>E (Etiket)</b></div>
                                <div class="col-md-8 border border-dark"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 border border-dark"><b>S (Serah)</b></div>
                                <div class="col-md-8 border border-dark"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 border border-dark text-center">
                                    <b>Menerima Obat Beserta Informasi</b>
                                    <br><br>
                                    (Pasien / Keluarga)
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 ">
                            <div class="row">
                                <div class="col-md-12 border border-dark text-center"><b>Perubahan Resep</b></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 border border-dark text-center"><b>Tertulis</b></div>
                                <div class="col-md-6 border border-dark text-center"><b>Menjadi</b></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 border border-dark text-center"><br><br></div>
                                <div class="col-md-6 border border-dark text-center"><br><br></div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6 border border-dark text-center"><b>Petugas Farmasi</b></div>
                                <div class="col-md-6 border border-dark text-center"><b>Disetujui</b></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 border border-dark text-center"><br><br>..................</div>
                                <div class="col-md-6 border border-dark text-center"><br><br>..................</div>
                            </div>
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
