@extends('adminlte::page')
@section('title', 'Kunjungan Pasien')
@section('content_header')
    <h1>Kunjungan Pasien</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Kunjungan" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tgl_masuk" label="Tanggal Masuk Kunjungan"
                                value="{{ $request->tgl_masuk ?? now()->format('Y-m-d') }}" placeholder="Pilih Tanggal"
                                :config="$config">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Antrian" />
                </form>
            </x-adminlte-card>
        </div>
        @if (isset($kunjungans))
            <div class="col-md-12">
                {{-- <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('taskid', 2)->first()->nomorantrean ?? 'Belum Panggil' }}"
                            text="Antrian Dilayani" theme="primary" icon="fas fa-user-injured"
                            url="{{ route('prosespendaftaran') }}?kodebooking={{ $antrians->where('taskid', 1)->first()->kodebooking ?? '00' }}"
                            url-text="Proses Antrian Selanjutnya" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', 1)->count() }}" text="Sisa Antrian"
                            theme="warning" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', '!=', 99)->count() }}"
                            text="Total Antrian" theme="success" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', 99)->count() }}" text="Batal Antrian"
                            theme="danger" icon="fas fa-user-injured" />
                    </div>
                </div> --}}
                <x-adminlte-card title="Data Kunjungan Pasien" theme="warning" icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['No', 'Tgl Masuk', 'Kode', 'Pasien', 'Jaminan', 'Jenis Kunjungan', 'SEP', 'Asesmen', 'Resep', 'Status'];
                        $config['order'] = [1, 'asc'];
                        $config['paging'] = false;
                        $config['scrollY'] = '300px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($kunjungans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tgl_masuk }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->norm }} {{ $item->nama }}</td>
                                <td>{{ $item->jaminan }}
                                    @if ($item->jaminan)
                                        {{ $item->jaminans }}
                                    @endif
                                </td>
                                <td>
                                    @switch($item->jeniskunjungan)
                                        @case(1)
                                            Rujukan FKTP
                                        @break

                                        @case(2)
                                            Umum / Rujukan Internal
                                        @break

                                        @case(3)
                                            Surat Kontrol
                                        @break

                                        @case(4)
                                            Rujukan Antar RS
                                        @break

                                        @default
                                    @endswitch
                                    <br>
                                    {{ $item->nomorreferensi }}
                                </td>
                                <td>{{ $item->sep }}</td>
                                <td>
                                    @if ($item->asesmendokter)
                                        <a class="btn btn-xs btn-success" target="_blank"
                                            href="{{ route('print_asesmendokter') }}?id={{ $item->asesmendokter->kodekunjungan }}">
                                            <i class="fas fa-print"></i> Asesmen Dokter</a>
                                    @endif

                                </td>
                                <td>
                                    @if ($item->resepobat)
                                        <a href="{{ route('print_asesmenfarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                            class="btn btn-xs btn-success" target="_blank"> <i class="fas fa-print"></i>
                                            Resep
                                            Obat</a>
                                    @endif
                                </td>
                                <td>{{ $item->status }}</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        @endif
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
