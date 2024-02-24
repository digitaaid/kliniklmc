@extends('adminlte::page')
@section('title', 'Kunjungan Pasien')
@section('content_header')
    <h1>Kunjungan Pasien</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Kunjungan Pasien" theme="secondary" icon="fas fa-info-circle" collapsible>
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-3">
                        @php
                            $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <form action="" method="get">
                            <x-adminlte-input-date name="tgl_masuk" igroup-size="sm"
                                placeholder="Pencarian Berdasakran Tanggal" :config="$config">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text text-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="primary" label="Cari" />
                                </x-slot>
                            </x-adminlte-input-date>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form action="" method="get">
                            <x-adminlte-input name="search" placeholder="Pencarian Berdasarkan Kode, No RM, Nama"
                                igroup-size="sm" value="{{ $request->search }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="primary" label="Cari" />
                                </x-slot>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text text-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </form>
                    </div>
                </div>
                @php
                    $heads = ['No', 'Tgl Masuk', 'Kode', 'No RM','Pasien', 'Unit', 'Jaminan', 'Jenis Kunjungan', 'SEP', 'Output', 'Status'];
                    $config['order'] = [1, 'asc'];
                    $config['paging'] = false;
                    $config['lengthMenu'] = false;
                    $config['searching'] = false;
                    $config['info'] = false;
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable
                    compressed>
                    @if (isset($kunjungans))
                        @foreach ($kunjungans as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->tgl_masuk }}</td>
                                <td>{{ $item->kode }} / {{ $item->counter }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->units->nama }}</td>
                                <td>{{ $item->jaminans->nama ?? '-' }}
                                    {{-- @if ($item->jaminan)
                                        {{ $item->jaminans }}
                                    @endif --}}
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
                                            Rujukan Antar RS
                                        @break

                                        @default
                                    @endswitch
                                    {{-- <br>
                                    {{ $item->nomorreferensi }} --}}
                                </td>
                                <td>
                                    @if ($item->sep)
                                        <a class="btn btn-xs btn-success" target="_blank"
                                            href="{{ route('sep_print') }}?noSep={{ $item->sep }}"
                                            style="text-decoration: none">
                                            <i class="fas fa-print"></i> {{ $item->sep }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($item->asesmendokter)
                                        <a class="btn btn-xs btn-success" target="_blank"
                                            href="{{ route('print_asesmendokter') }}?id={{ $item->asesmendokter->kodekunjungan }}">
                                            <i class="fas fa-print"></i> Asesmenper</a>
                                    @else
                                        -
                                    @endif
                                    {{-- {{ $item->kode }} {{ $item->antrian->kodebooking }} --}}
                                    @if ($item->antrian->kodebooking)
                                        <a href="{{ route('print_asesmenfarmasi') }}?kodebooking={{ $item->antrian->kodebooking }}"
                                            class="btn btn-xs btn-success" target="_blank"> <i class="fas fa-print"></i>
                                            Resep</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->status }}</td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
                <div class="row">
                    <div class="col-md-5">
                        Tampil data {{ $kunjungans->firstItem() }} sampai {{ $kunjungans->lastItem() }} dari total
                        {{ $total_kunjungan }}
                    </div>
                    <div class="col-md-7">
                        <div class="float-right pagination-sm">
                            {{ $kunjungans->links() }}
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
