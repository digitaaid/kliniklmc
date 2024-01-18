@extends('adminlte::page')
@section('title', 'Antrian Poliklinik')
@section('content_header')
    <h1>Antrian Poliklinik</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-small-box title="{{ $sedang_antrian ? $sedang_antrian->nomorantrean : 'Belum Panggil' }}"
                        text="Antrian Sedang Dilayani" theme="primary" icon="fas fa-user-injured"
                        url="{{ route('prosespoliklinik') }}?kodebooking={{ $sedang_antrian->kodebooking ?? '00' }}"
                        url-text="Proses Antrian Selanjutnya" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-small-box title="{{ $sisa_antrian }}" text="Sisa Antrian Hari Ini" theme="warning"
                        icon="fas fa-user-injured" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-small-box title="{{ $total_antrian }}" text="Total Antrian Hari Ini" theme="success"
                        icon="fas fa-user-injured" />
                </div>
            </div>
            <x-adminlte-card title="Data Antrian Asesmen Dokter" theme="warning" icon="fas fa-info-circle" collapsible>
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
                    $heads = ['Tanggal', 'No', 'No RM', 'Pasien', 'Action', 'Jenis Pasien', 'Unit', 'Dokter', 'Taskid', 'Asesmen'];
                    $config['order'] = [[6, 'asc'], [7, 'asc']];
                    $config['paging'] = false;
                    $config['scrollY'] = '300px';
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable
                    compressed>
                    @foreach ($antrians as $item)
                        <tr>
                            <td>{{ $item->tanggalperiksa }}</td>
                            <td>A{{ $item->angkaantrean }}</td>
                            <td>{{ $item->norm }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                @switch($item->taskid)
                                    @case(3)
                                        <a href="{{ route('prosespoliklinik') }}?kodebooking={{ $item->kodebooking }}"
                                            class="btn btn-xs btn-warning withLoad">Proses</a>
                                    @break

                                    @case(4)
                                        <a href="{{ route('prosespoliklinik') }}?kodebooking={{ $item->kodebooking }}"
                                            class="btn btn-xs btn-primary withLoad">Proses</a>
                                    @break

                                    @default
                                        <a href="{{ route('prosespoliklinik') }}?kodebooking={{ $item->kodebooking }}"
                                            class="btn btn-xs btn-secondary withLoad">Lihat</a>
                                @endswitch
                            </td>
                            <td>{{ $item->jenispasien }} </td>
                            <td>{{ $item->kunjungan ? $item->kunjungan->units->nama : '-' }}</td>
                            <td>{{ $item->namadokter }}</td>
                            <td>
                                @switch($item->taskid)
                                    @case(0)
                                        <span class="badge badge-secondary">98. Belum Checkin</span>
                                    @break

                                    @case(1)
                                        <span class="badge badge-warning">97. Menunggu Pendaftaran</span>
                                    @break

                                    @case(2)
                                        <span class="badge badge-primary">96. Proses Pendaftaran</span>
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
                                @if ($item->asesmendokter)
                                    <span class="badge badge-success">Sudah Asesmen</span>
                                @else
                                    <span class="badge badge-danger">Belum Asesmen</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
