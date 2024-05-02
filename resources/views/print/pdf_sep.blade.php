@extends('print.pdf_layout')
@section('title', 'Print SEP BPJS')

@section('content')
    @include('print.pdf_kop_bpjs')
    <table class="table table-sm" style="font-size: 11px">
        <tr>
            <td width="100%" colspan="2" class="text-center">
                <b class="text-md">SURAT ELEGTABILITAS PASIEN (SEP) BPJS RAWAT JALAN</b> <br>
                <b class="text-md">No. {{ $sep->noSep }}</b>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>No SEP</td>
                        <td>:</td>
                        <td><b>{{ $sep->noSep }}</b></td>
                    </tr>
                    <tr>
                        <td>Tgl SEP</td>
                        <td>:</td>
                        <td><b>{{ $sep->tglSep }}</b></td>
                    </tr>
                    <tr>
                        <td>Nomor Kartu</td>
                        <td>:</td>
                        <td><b>{{ $sep->peserta->noKartu }}</b></td>
                    </tr>
                    <tr>
                        <td>Nomor RM</td>
                        <td>:</td>
                        <td><b>{{ $sep->peserta->noMr }}</b></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><b>{{ $sep->peserta->nama }}</b></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td><b>{{ $sep->peserta->tglLahir }}</b></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td><b> {{ $sep->peserta->kelamin }}</b></td>
                    </tr>
                    <tr>
                        <td>Jenis Peserta</td>
                        <td>:</td>
                        <td><b>{{ $sep->peserta->jnsPeserta }}</b></td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>No Rujukan</td>
                        <td>:</td>
                        <td><b>{{ $sep->noRujukan }}</b></td>
                    </tr>
                    <tr>
                        <td>No Surat Kontrol</td>
                        <td>:</td>
                        <td><b>{{ $sep->kontrol->noSurat }}</b></td>
                    </tr>
                    <tr>
                        <td>Jenis Pelayanan</td>
                        <td>:</td>
                        <td><b>{{ $sep->jnsPelayanan }}</b></td>
                    </tr>
                    <tr>
                        <td>Kelas Rawat</td>
                        <td>:</td>
                        <td><b>{{ $sep->kelasRawat }}</b></td>
                    </tr>
                    <tr>
                        <td>Poli Tujuan</td>
                        <td>:</td>
                        <td><b>{{ $sep->poli }}</b></td>
                    </tr>
                    <tr>
                        <td> DPJP</td>
                        <td>:</td>
                        <td><b>{{ $sep->dpjp->nmDPJP }}</b></td>
                    </tr>
                    <tr>
                        <td>Diagnosa Awal</td>
                        <td>:</td>
                        <td><b>{{ $sep->diagnosa }}</b></td>
                    </tr>
                    <tr>
                        <td>Catatan</td>
                        <td>:</td>
                        <td><b>{{ $sep->catatan }}</b></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td width="50%">
                Catatan:
                <ol style="margin: 0px;">
                    <li style="margin: 0px;">
                        <i>Saya Menyetujui BPJS Kesehatan menggunakan Informasi Medis Pasien jika diperlukan</i>
                    </li>
                    <li style="margin: 0px;">
                        <i>SEP bukan sebagai bukti penjaminan peserta</i>
                    </li>
                </ol>
                <p>Waktu Cetak : {{ now() }}</p>
            </td>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td style="padding-left: 10px">
                            <b> Pasien/<br>
                                Keluarga Pasien
                            </b>
                            <br><br><br><br>
                            <hr>
                        </td>
                        <td style="padding-left: 30px">
                            <b> Petugas<br>
                                BPJS Kesehatan
                            </b>
                            <br><br><br><br>
                            <hr>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
    <style>
        @page {
            size: 210mm 100mm;
            /* Misalnya ukuran A4 */
        }
    </style>
@endsection
