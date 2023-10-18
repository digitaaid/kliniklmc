@extends('adminlte::page')
@section('title', 'Surat Kontrol')
@section('content_header')
    <h1>Surat Kontrol</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Surat Kontrol" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        @php
                            $config = [
                                'timePicker' => false,
                                'locale' => ['format' => 'YYYY/MM/DD'],
                            ];
                        @endphp
                        <x-adminlte-date-range fgroup-class="col-md-6" name="tanggal" igroup-size="sm" :config="$config"
                            label="Periode Tanggal" />
                        <x-adminlte-select fgroup-class="col-md-6" igroup-size="sm" name="formatfilter"
                            label="Format Filter">
                            <option value="1" {{ $request->formatfilter == '1' ? 'selected' : null }}>Tanggal Entri
                            </option>
                            <option value="2" {{ $request->formatfilter == '2' ? 'selected' : null }}>Tanggal
                                Rencana Kontrol
                            </option>
                        </x-adminlte-select>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Antrian" />
                </form>
            </x-adminlte-card>
        </div>
        @if (isset($suratkontrols))
            <div class="col-md-12">
                <x-adminlte-card title="Data Surat Kontrol" theme="primary" icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['Tgl Kontrol', 'No Surat', 'Pelayanan', 'Poliklinik', 'Dokter', 'Pasien', 'Terbi SEP', 'Action'];
                        $config['order'] = [1, 'asc'];
                        $config['paging'] = false;
                        $config['scrollY'] = '300px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($suratkontrols as $item)
                            <tr>
                                <td>{{ $item->tglRencanaKontrol }}</td>
                                <td>{{ $item->noSuratKontrol }}</td>
                                <td>{{ $item->jnsPelayanan }}</td>
                                <td>{{ $item->namaPoliTujuan }}</td>
                                <td>{{ $item->namaDokter }}</td>
                                <td>{{ $item->noKartu }} {{ $item->nama }}</td>
                                <td>{{ $item->terbitSEP }}</td>
                                <td></td>
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
@section('plugins.DateRangePicker', true)
@section('plugins.Select2', true)
