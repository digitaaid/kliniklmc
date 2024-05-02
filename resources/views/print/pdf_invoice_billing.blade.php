@extends('print.pdf_layout')
@section('title', 'Print Surat Kontrol BPJS')

@section('content')
    @include('print.pdf_kop')
    <table class="table table-sm" style="font-size: 11px">
        <tr>
            <td width="100%" colspan="2" class="text-center">
                <b class="text-md">INVOICE BILLING PASIEN</b> <br>
                <b class="text-md">No. {{ $kunjungan->kode }}</b>
            </td>
        </tr>
    </table>
    <table class="table table-sm table-bordered" style="font-size: 11px">
        <tr>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><b>{{ $pasien->nama }}</b></td>
                    </tr>
                    <tr>
                        <td>No RM</td>
                        <td>:</td>
                        <td><b>{{ $pasien->norm }}</b></td>
                    </tr>

                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><b>{{ $pasien->nohp }}</b></td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>Tanggal Kunjungan</td>
                        <td>:</td>
                        <td><b>{{ $kunjungan->tgl_masuk }}</b></td>
                    </tr>
                    <tr>
                        <td>Poliklinik</td>
                        <td>:</td>
                        <td><b>{{ $kunjungan->units->nama }}</b></td>
                    </tr>
                    <tr>
                        <td>Jenis Kunjungan</td>
                        <td>:</td>
                        <td><b>{{ $kunjungan->jeniskunjungan }}</b></td>
                    </tr>

                </table>
            </td>
        </tr>
        </td>
        <tr>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td colspan="3"><b><u>Rincian Biaya</u></b></td>
                    </tr>
                    @foreach ($layanans->groupBy('klasifikasi') as $klasifikasi => $layananx)
                        <tr>
                            <td><b>{{ $klasifikasi }}</b></td>
                            <td>:</td>
                            <td class="text-right"><b>{{ money($layananx->sum('harga'), 'IDR') }}</b></td>
                        </tr>
                        @foreach ($layananx as $layanan)
                            <tr>
                                <td><span style="margin-left : 15px">{{ $layanan->nama }} </span></td>
                                <td>:</td>
                                <td class="text-right">{{ money($layanan->harga, 'IDR') }}</td>
                            </tr>
                        @endforeach
                        <hr>
                    @endforeach
                    <tr>
                        <td><b>Total Biaya</b></td>
                        <td>:</td>
                        <td class="text-right"><b>{{ money($layanans->sum('harga'), 'IDR') }}</b></td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td colspan="3"><b>Jaminan Pembayaran</b></td>
                    </tr>
                    @foreach ($layanans->groupBy('jaminan') as $klasifikasi => $layananx)
                        <tr>
                            <td>{{ $klasifikasi }}</td>
                            <td>:</td>
                            <td class="text-right">{{ money($layananx->sum('harga'), 'IDR') }}</td>
                        </tr>
                    @endforeach
                    <hr>
                    <tr>
                        <td><b>Deposit</b></td>
                        <td>:</td>
                        <td class="text-right">{{ money(0, 'IDR') }}</td>
                    </tr>
                    <tr>
                        <td><b>Pembayaran Cash</b></td>
                        <td>:</td>
                        <td class="text-right">{{ money(0, 'IDR') }}</td>
                    </tr>
                    <tr>
                        <td><b>Sisa Pembayaran</b></td>
                        <td>:</td>
                        <td class="text-right">{{ money(0, 'IDR') }}</td>
                    </tr>


                </table>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <table class="table-borderless" style="width: 100%">
                    <tr>
                        <td class="text-center">
                            <b>Petigas Kasir</b>
                            <br><br><br>
                            <b>Petigas Kasir</b>
                        </td>
                        <td class="text-center">
                            <b>Pasien</b>
                            <br><br><br>
                            <b>Petigas Kasir</b>
                        </td>
                    </tr>

                </table>
            </td>
            <td width="50%">
                <i>Terima Kasih dan Semoga Lekas Sembuh</i>
            </td>
        </tr>
    </table>
    <style>
        @page {
            size: 'A4';
            /* Misalnya ukuran A4 */
        }
    </style>
@endsection
