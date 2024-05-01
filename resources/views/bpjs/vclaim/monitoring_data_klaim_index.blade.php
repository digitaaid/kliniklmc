@extends('adminlte::page')
@section('title', 'Monitoring Data Klaim')
@section('content_header')
    <h1>Monitoring Data Klaim </h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" theme-mode="outline">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                                igroup-size="sm" name="tanggalPulang" label="Tanggal Pulang" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggalPulang)->format('Y-m-d') }}">
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select2 fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                                igroup-size="sm" name="jenisPelayanan" label="Jenis Pelayanan">
                                <option value="1" {{ $request->jenisPelayanan == 1 ? 'selected' : null }}>Rawat Inap
                                </option>
                                <option value="2" {{ $request->jenisPelayanan == 2 ? 'selected' : null }}>Rawat Jalan
                                </option>
                            </x-adminlte-select2>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select2 fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                                igroup-size="sm" name="statusKlaim" label="Status Klaim">
                                <option value="1" {{ $request->statusKlaim == 1 ? 'selected' : null }}>Proses
                                    Verifikasi
                                    Pending</option>
                                <option value="2" {{ $request->statusKlaim == 2 ? 'selected' : null }}>Pending
                                    Varifikasi
                                </option>
                                <option value="3" {{ $request->statusKlaim == 3 ? 'selected' : null }}>Klaim</option>
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Cari!" />
                                </x-slot>
                            </x-adminlte-select2>
                        </div>
                    </div>
                </form>
                @php
                $heads = [
                    'Nama',
                    'No RM',
                    'No BPJS',
                    'FPK',
                    'SEP',
                    'Tgl Masuk',
                    'Tgl Pulang',
                    'Poliklinik ',
                    'Kelas ',
                    'Kode INACBG',
                    'Desc INACBG',
                    'Status',
                    'byPengajuan',
                    'bySetujui',
                    'byTarifGruper',
                    'byTopup',
                    'byTarifRS',
                    'LabaRugi',
                ];
                // $config['fixedColumns'] = [
                //     'leftColumns' => 1,
                // ];
                $config['paging'] = false;
                $config['scrollX'] = true;
            @endphp
            <x-adminlte-datatable id="table2" class="nowrap text-xs" :config="$config" :heads="$heads" bordered
                hoverable compressed>
                @php
                    $byTarifRS = 0;
                    $byTarifGruper = 0;
                    $byTopup = 0;
                    $byPengajuan = 0;
                    $bySetujui = 0;
                @endphp
                @isset($klaim)
                    @foreach ($klaim as $item)
                        <tr>
                            <td>{{ $item->peserta->nama }}</td>
                            <td>{{ $item->peserta->noMR }}</td>
                            <td>{{ $item->peserta->noKartu }}</td>
                            <td>{{ $item->noFPK }}</td>
                            <td>{{ $item->noSEP }}</td>
                            <td>{{ $item->tglSep }}</td>
                            <td>{{ $item->tglPulang }}</td>
                            <td>{{ $item->poli }}</td>
                            <td>{{ $item->kelasRawat }}</td>
                            <td>{{ $item->Inacbg->kode }}</td>
                            <td>{{substr($item->Inacbg->nama, 0, 20) }}...</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ money($item->biaya->byPengajuan, 'IDR') }}</td>
                            <td>{{ money($item->biaya->bySetujui, 'IDR') }}</td>
                            <td>{{ money($item->biaya->byTarifGruper, 'IDR') }}</td>
                            <td>{{ money($item->biaya->byTopup, 'IDR') }}</td>
                            <td>{{ money($item->biaya->byTarifRS, 'IDR') }}</td>
                            <td
                                class="{{ $item->biaya->bySetujui - $item->biaya->byTarifRS > 0 ? 'table-success' : 'table-danger' }}">
                                {{ number_format($item->biaya->bySetujui - $item->biaya->byTarifRS, 0, ',', '.') }}</td>
                        </tr>
                        @php
                            $byTarifRS += $item->biaya->byTarifRS;
                            $byTarifGruper += $item->biaya->byTarifGruper;
                            $byTopup += $item->biaya->byTopup;
                            $byPengajuan += $item->biaya->byPengajuan;
                            $bySetujui += $item->biaya->bySetujui;
                        @endphp

                    @endforeach
                    <tfoot>
                        <tr class="{{ $bySetujui - $byTarifRS > 0 ? 'table-success' : 'table-danger' }}">
                            <th colspan="12" class="text-center">Total</th>
                            <th>{{ money($byPengajuan, 'IDR') }}</th>
                            <th>{{ money($bySetujui, 'IDR') }}</th>
                            <th>{{ money($byTarifGruper, 'IDR') }}</th>
                            <th>{{ money($byTopup, 'IDR') }}</th>
                            <th>{{ money($byTarifRS, 'IDR') }}</th>
                            <th>{{ money($bySetujui - $byTarifRS, 'IDR') }}</th>
                        </tr>
                    </tfoot>
                @endisset
            </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
{{-- @section('plugins.DatatablesFixedColumns', true) --}}
@section('plugins.TempusDominusBs4', true)
