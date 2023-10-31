@extends('adminlte::page')
@section('title', 'Riwayat Pasien')
@section('content_header')
    <h1>Riwayat Pasien</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <a href="{{ route('pasien.index') }}" class="btn btn-danger mb-2 mr-1 withLoad">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @include('sim.profil_riwayat_pasien')
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 600px ;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="card card-info mb-1">
                            <div class="card-header" role="tab" id="headKunjungan">
                                <h3 class="card-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collKunjungan"
                                        aria-expanded="true" aria-controls="collKunjungan">
                                        Riwayat Kunjungan ({{ $pasien->kunjungans->count() }})
                                    </a>
                                </h3>
                            </div>
                            <div id="collKunjungan" class="collapse" role="tabpanel" aria-labelledby="headKunjungan">
                                <div class="card-body">
                                    teasdasd
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('js')

@endsection
