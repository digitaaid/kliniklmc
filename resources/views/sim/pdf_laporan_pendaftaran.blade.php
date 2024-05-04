@extends('print.pdf_layout')
@section('title', 'Print SEP BPJS')

@section('content')
    @include('print.pdf_kop')
    <div class="text-center w-100" style="font-size: 11px">
        <br>
        <b>LAPORAN PENDAFTRAN</b> <br>
        <b>Periode {{ $request->tanggal }}</b>
        <br><br>
    </div>
    <table class='table table-sm table-bordered' style="font-size: 11px">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>No BPJS</th>
                <th>Status</th>
                <th>JnsKunjgan</th>
                <th>JnsPsien</th>
                <th>Jaminan</th>
                <th>Asal Perujuk</th>
                <th>SEP</th>
                <th>PIC</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($antrians->where('taskid', 7) as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggalperiksa }}</td>
                    <td>{{ $item->norm }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nomorkartu }}</td>
                    <td>
                        @if ($item->kunjungan->counter == 1)
                            BARU
                        @else
                            LAMA
                        @endif
                    </td>
                    <td>
                        @switch($item->jeniskunjungan)
                            @case(1)
                                Rujukan FKTP
                            @break

                            @case(2)
                                Umum
                            @break

                            @case(3)
                                Surat Kontrol
                            @break

                            @case(4)
                                Rujukan Antrar RS
                            @break

                            @default
                                -
                        @endswitch
                    </td>
                    <td>{{ $item->jenispasien }} </td>
                    <td>{{ $item->kunjungan->jaminans->nama }} </td>
                    <td>{{ $item->perujuk ?? '-' }}</td>
                    <td>{{ $item->kunjungan->sep ?? '-' }} </td>
                    <td>{{ $item->pic1 ? $item->pic1->name : $item->user1 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <style>
        .table th,
        .table td {
            padding: 2px !important;
            vertical-align: top;
        }

        @page {
            size: landscape;
            /* Misalnya ukuran A4 */
        }
    </style>
    {{-- @media print{@page {}} --}}
@endsection
