@extends('adminlte::page')
@section('title', 'Antrian Farmasi')
@section('content_header')
    <h1>Antrian Farmasi</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Data Antrian" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggalperiksa" label="Tanggal Antrian"
                                value="{{ $request->tanggalperiksa }}" placeholder="Pilih Tanggal" :config="$config">
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
        @if (isset($antrians))
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('taskid', 6)->first()->nomorantrean ?? 'Belum Panggil' }}"
                            text="Antrian Dilayani" theme="primary" icon="fas fa-user-injured"
                            url="{{ route('prosesfarmasi') }}?kodebooking={{ $antrians->where('taskid', 5)->first()->kodebooking ?? '00' }}"
                            url-text="Proses Antrian Selanjutnya" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', '<=', 3)->count() }}" text="Sisa Antrian"
                            theme="warning" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', '!=', 99)->count() }}"
                            text="Total Antrian" theme="success" icon="fas fa-user-injured" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <x-adminlte-card title="Data Antrian Farmasi" theme="warning" icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['No', 'Kodebooking', 'Pasien', 'Kartu BPJS', 'Unit', 'Dokter', 'Jenis Pasien', 'Method', 'Status', 'Action'];
                        $config['order'] = [[7, 'asc']];
                        $config['paging'] = false;
                        $config['scrollY'] = '300px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->angkaantrean }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->norm }} {{ $item->nama }}</td>
                                <td>{{ $item->nomorkartu }}</td>
                                <td>{{ $item->namapoli }}</td>
                                <td>{{ $item->namadokter }}</td>
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
                                        @break

                                        @default
                                            {{ $item->taskid }}
                                    @endswitch
                                </td>
                                <td>
                                    @switch($item->taskid)
                                        @case(5)
                                            <a href="{{ route('terimafarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                                class="btn btn-xs btn-warning withLoad">Terima</a>
                                        @break

                                        @case(6)
                                            <a href="{{ route('selesaifarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                                class="btn btn-xs btn-success withLoad">Selesai</a>
                                        @break

                                        @default
                                            <div class="btn btn-xs btn-secondary">
                                                Pulang
                                            </div>
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <div class="row">
                    @foreach ($antrians->where('taskid', 6) as $item)
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $item->kunjungan->nama }}</h3> <br>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <p>
                                        <b>No RM : </b> {{ $item->kunjungan->norm }} <br>
                                        <b>Nama : </b> {{ $item->kunjungan->nama }} <br>
                                        <b>Tgl Lahir : </b> {{ $item->kunjungan->tgl_lahir }} <br>
                                        <b>Kelamin : </b> {{ $item->kunjungan->gender }}
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-pills mr-1"></i> Resep Obat</strong>
                                    <pre>{{ $item->kunjungan->asesmendokter->riwayat_pengobatan }}</pre>
                                    <hr>
                                    <strong><i class="fas fa-pills mr-1"></i> Catatan Resep</strong>
                                    <pre>{{ $item->kunjungan->asesmendokter->riwayat_pengobatan }}</pre>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('selesaifarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                        class="btn btn-success withLoad">Selesai</a>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)

@section('css')
    <style>
        pre {
            padding: 0 !important;
            font-size: 15px !important;
        }
    </style>
@endsection
