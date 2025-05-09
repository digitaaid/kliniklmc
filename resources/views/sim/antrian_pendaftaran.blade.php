@extends('adminlte::page')
@section('title', 'Antrian Pendaftaran')
@section('content_header')
    <h1>Antrian Pendaftaran</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (isset($antrians))
                <div class="row">
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
                </div>
            @endif
        </div>

        <div class="col-md-12">
            <x-adminlte-card title="Data Antrian Pendaftaran" theme="secondary" icon="fas fa-info-circle" collapsible>
                <div class="row">
                    <div class="col-md-4">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                        $config = ['format' => 'YYYY-MM-DD'];
                                    @endphp
                                    <x-adminlte-input-date name="tanggalperiksa"
                                        value="{{ $request->tanggalperiksa ?? now()->format('Y-m-d') }}"
                                        placeholder="Pilih Tanggal" igroup-size="sm" :config="$config">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-primary">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button type="submit" theme="primary" label="Cari Tanggal" />
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <form action="" method="get">
                            <x-adminlte-input name="pencarian" placeholder="Pencarian Berdasarkan Nama / No RM"
                                igroup-size="sm" value="{{ $request->pencarian }}">
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
                    $heads = [
                        'No',
                        'Kodebooking',
                        'Action',
                        'Pasien',
                        'Kartu BPJS',
                        'Unit / Dokter',
                        'Jenis Pasien',
                        'Method',
                        'Taskid',
                        'Status',
                    ];
                    $config['order'] = [8, 'asc'];
                    $config['paging'] = false;
                    $config['scrollY'] = '300px';
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable
                    compressed>
                    @if (isset($antrians))
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->angkaantrean }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>
                                    @switch($item->taskid)
                                        @case(1)
                                            <a href="{{ route('prosespendaftaran') }}?kodebooking={{ $item->kodebooking }}"
                                                class="btn btn-xs btn-warning withLoad">Proses</a>
                                            <a href="{{ route('lihatpendaftaran') }}?kodebooking={{ $item->kodebooking }}"
                                                class="btn btn-xs btn-secondary withLoad">Lihat</a>
                                        @break

                                        @case(2)
                                            <a href="{{ route('lihatpendaftaran') }}?kodebooking={{ $item->kodebooking }}"
                                                class="btn btn-xs btn-primary withLoad">Proses</a>
                                        @break

                                        @default
                                            <a href="{{ route('lihatpendaftaran') }}?kodebooking={{ $item->kodebooking }}"
                                                class="btn btn-xs btn-secondary withLoad">Lihat</a>
                                    @endswitch

                                </td>
                                <td>{{ $item->norm }} {{ $item->nama }}</td>
                                <td>{{ $item->nomorkartu }}</td>
                                <td>{{ $item->kodepoli }} / {{ $item->namadokter }}</td>
                                <td>{{ $item->jenispasien }} </td>
                                <td>{{ $item->method }} </td>
                                <td>
                                    @switch($item->taskid)
                                        @case(0)
                                            <span class="badge badge-secondary">98. Belum Checkin</span>
                                        @break

                                        @case(1)
                                            <span class="badge badge-warning">1. Menunggu Pendaftaran</span>
                                        @break

                                        @case(2)
                                            <span class="badge badge-primary">0. Proses Pendaftaran</span>
                                        @break

                                        @case(3)
                                            <span class="badge badge-warning">3. Menunggu Poliklinik</span>
                                        @break

                                        @case(4)
                                            <span class="badge badge-primary">4. Pelayanan Poliklinik</span>
                                        @break

                                        @case(5)
                                            <span class="badge badge-warning">5. Tunggu Farmasi</span>
                                        @break

                                        @case(6)
                                            <span class="badge badge-primary">6. Racik Obat</span>
                                        @break

                                        @case(7)
                                            <span class="badge badge-success">7. Selesai</span>
                                        @break

                                        @case(99)
                                            <span class="badge badge-danger">99. Batal</span>
                                            <a href="{{ route('tidakjadibatal') }}?kodebooking={{ $item->kodebooking }}"
                                                class="btn btn-xs btn-primary withLoad"><i class="fas fa-sync"></i> </a>
                                        @break

                                        @default
                                            {{ $item->taskid }}
                                    @endswitch
                                </td>
                                <td>{{ $item->status }} </td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
