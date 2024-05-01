@extends('print.pdf_layout')
@section('title', 'Print Surat Kontrol BPJS')

@section('content')
    @include('print.pdf_kop')
    <table class="table table-sm" style="font-size: 11px">
        <tr>
            <td width="100%" colspan="2" class="text-center">
                <b class="text-md">SURAT KONTROL BPJS RAWAT JALAN</b> <br>
                <b class="text-md">No. {{ $suratkontrol->noSuratKontrol }}</b>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><b>{{ $peserta->nama }}</b></td>
                    </tr>
                    <tr>
                        <td>Nomor BPJS</td>
                        <td>:</td>
                        <td><b>{{ $peserta->noKartu }}</b></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td><b>{{ $peserta->kelamin }}</b></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td><b>{{ $peserta->tglLahir }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3"> -</td>
                    </tr>
                    <tr>
                        <td>Tanggal Kontrol</td>
                        <td>:</td>
                        <td><b>{{ $suratkontrol->tglRencanaKontrol }}</b></td>
                    </tr>
                    <tr>
                        <td>Tanggal Terbit</td>
                        <td>:</td>
                        <td><b>{{ $suratkontrol->tglTerbit }}</b></td>
                    </tr>
                    <tr>
                        <td>Jenis Kontrol</td>
                        <td>:</td>
                        <td><b>{{ $suratkontrol->namaJnsKontrol }}</b></td>
                    </tr>
                    <tr>
                        <td>Poliklinik Tujuan</td>
                        <td>:</td>
                        <td><b>{{ $suratkontrol->namaPoliTujuan }}</b></td>
                    </tr>
                    <tr>
                        <td>Dokter</td>
                        <td>:</td>
                        <td><b>{{ $dokter->namadokter }}</b></td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>No SEP</td>
                        <td>:</td>
                        <td><b>{{ $sep->noSep }}</b></td>
                    </tr>
                    <tr>
                        <td>Tanggal SEP</td>
                        <td>:</td>
                        <td><b>{{ $sep->tglSep }}</b></td>
                    </tr>
                    <tr>
                        <td>Jenis Pelayanan</td>
                        <td>:</td>
                        <td><b>{{ $sep->jnsPelayanan }}</b></td>
                    </tr>
                    <tr>
                        <td>Poliklinik</td>
                        <td>:</td>
                        <td><b>{{ $sep->poli }}</b></td>
                    </tr>
                    <tr>
                        <td>Diagnosa</td>
                        <td>:</td>
                        <td><b>{{ $sep->diagnosa }}</b></td>
                    </tr>
                    <tr>
                        <td>Prov. Perujuk</td>
                        <td>:</td>
                        <td><b>{{ $sep->provPerujuk->nmProviderPerujuk }}</b></td>
                    </tr>
                    <tr>
                        <td>Asal Rujukan</td>
                        <td>:</td>
                        <td><b>
                                @if ($sep->provPerujuk->asalRujukan == 1)
                                    Faskes Tingkat Pertama
                                @else
                                @endif

                            </b></td>
                    </tr>
                    <tr>
                        <td>No Rujukan</td>
                        <td>:</td>
                        <td><b>{{ $sep->provPerujuk->noRujukan }}</b></td>
                    </tr>
                    <tr>
                        <td>Tanggal Rujukan</td>
                        <td>:</td>
                        <td><b>{{ $sep->provPerujuk->tglRujukan }}</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                Dengan ini pasien diatas belum dapat dikembalikan ke Fasilitas Kesehatan Perujuk. Rencana tindak
                lanjut akan dilanjutkan pada kunjungan selanjutnya.
                Surat Keterangan ini hanya dapat digunakan 1 (satu) kali pada kunjungan dengan diagnosa diatas.
            </td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td width="50%">
                <b> Waled, {{ Carbon\Carbon::now()->translatedFormat('d F Y') }} <br>
                    DPJP,</b>

                <br><br><br>
                <b><u>{{ $dokter->namadokter }}</u></b>
            </td>
        </tr>
    </table>
    <style>
        @page {
            size: 210mm 130mm;
            /* Misalnya ukuran A4 */
        }
    </style>
@endsection
