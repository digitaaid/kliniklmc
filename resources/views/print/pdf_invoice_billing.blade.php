@extends('print.pdf_layout')
@section('title', 'Print Surat Kontrol BPJS')

@section('content')
    @include('print.pdf_kop')
    <table class="table table-sm" style="font-size:11px;">
        <tr>
            <td width="100%" colspan="2" class="text-center">
                <b class="text-md">INVOICE BILLING PASIEN</b> <br>
                <b class="text-md">No. {{ $kunjungan->kode }}</b>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <table class="table  table-sm  table-borderless">
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
                        <td>No HP</td>
                        <td>:</td>
                        <td><b>{{ $pasien->nohp }}</b></td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="table  table-sm  table-borderless">
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
                        <td><b>
                                @switch($kunjungan->jeniskunjungan)
                                    @case(1)
                                        RUJUKAN FKTP (JKN)
                                    @break

                                    @case(2)
                                        UMUM (NON-JKN)
                                    @break

                                    @case(3)
                                        SURAT KONTROL (JKN)
                                    @break

                                    @case(4)
                                        RUJUKAN ANTAR RS (JKN)
                                    @break

                                    @default
                                @endswitch

                            </b></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table table-sm" style="font-size:11px;">
        <tr>
            <td width="70%">
                <table class="table table-xs table-bordered">
                    <tr>
                        <th class="text-left">Rincian Biaya</th>
                        <th class="text-right">Harga</th>
                        <th class="text-left"></th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                    @foreach ($layanans as $layanan)
                        <tr>
                            <td>{{ $layanan->nama }}</td>
                            <td class="text-right">{{ money($layanan->harga, 'IDR') }}</td>
                            <td>x{{ $layanan->jumlah }}
                                @if ($layanan->diskon)
                                    *Disc {{ $layanan->diskon }}%
                                @endif
                            </td>
                            <td class="text-right">{{ money($layanan->subtotal, 'IDR') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">
                            <b>Total Biaya</b>
                        </td>
                        <td class="text-right">
                            <b>{{ money($layanans->sum('subtotal'), 'IDR') }}</b>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="30%">
                <table class="table-borderless">
                    <tr>
                        <td colspan="3"><b>Jaminan Pembayaran</b></td>
                    </tr>
                    @foreach ($layanans->groupBy('jaminan') as $klasifikasi => $layananx)
                        <tr>
                            <td>{{ $layananx->first()->jaminans->nama }}</td>
                            <td>:</td>
                            <td class="text-right">{{ money($layananx->sum('subtotal'), 'IDR') }}</td>
                        </tr>
                    @endforeach
                    {{-- <hr> --}}
                    {{-- <tr>
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
                    </tr> --}}
                </table>
            </td>
        </tr>
        <tr>
            <td width="70%">
                <table class="table-borderless" style="width: 100%">
                    <tr>
                        <td class="text-center">
                            <b>Pasien</b>
                            <br><br><br>
                            <b>(.................)</b>
                        </td>
                        <td class="text-center">
                            <b>Petugas</b>
                            <br><br><br>
                            <b>(.................)</b>
                        </td>
                    </tr>

                </table>
            </td>
            <td width="30%">
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
