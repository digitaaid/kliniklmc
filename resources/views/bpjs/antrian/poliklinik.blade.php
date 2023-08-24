@extends('adminlte::page')
@section('title', 'Poliklinik - Antrian BPJS')
@section('content_header')
    <h1>Poliklinik Antrian BPJS</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Referensi Poliklinik Antrian BPJS" theme="secondary" collapsible>
                @php
                    $heads = ['Nama Subspesialis', 'Kode Subspesialis', 'Nama Poli', 'Kode Poli'];
                @endphp
                <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" hoverable bordered compressed>
                    @if ($polikliniks)
                        @foreach ($polikliniks as $poliklinik)
                            <tr>
                                <td>{{ $poliklinik->nmsubspesialis }}</td>
                                <td>{{ $poliklinik->kdsubspesialis }}</td>
                                <td>{{ $poliklinik->nmpoli }}</td>
                                <td>{{ $poliklinik->kdpoli }}</td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
                <a href="{{ route('poliklinik.create') }}" class="btn btn-warning">Refresh Datak Poliklinik</a>
            </x-adminlte-card>
            <x-adminlte-card title="Referensi Poliklinik Fingerprint Antrian BPJS" theme="secondary" collapsible>
                @php
                    $heads = ['Nama Subspesialis', 'Kode Subspesialis', 'Nama Poli', 'Kode Poli'];
                @endphp
                <x-adminlte-datatable id="table2" class="text-xs" :heads="$heads" hoverable bordered compressed>
                    @if ($fingerprint)
                        @foreach ($fingerprint as $poliklinik)
                            <tr>
                                <td>{{ $poliklinik->namasubspesialis }}</td>
                                <td>{{ $poliklinik->kodesubspesialis }}</td>
                                <td>{{ $poliklinik->namapoli }}</td>
                                <td>{{ $poliklinik->kodepoli }}</td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
