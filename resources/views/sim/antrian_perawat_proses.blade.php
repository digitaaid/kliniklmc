@extends('adminlte::page')
@section('title', 'Antrian Perawat')
@section('content_header')
    <h1>Antrian Perawat</h1>
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
            <a href="{{ route('antrianperawat') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
                class="btn btn-xs btn-danger mb-2 mr-1 withLoad">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div class="btn btn-xs btn-{{ $antrian->asesmenperawat ? 'success' : 'secondary' }} mb-2 mr-1">
                <i class="fas fa-info-circle"></i>
                Status Antrian :
                @switch($antrian->taskid)
                    @case(0)
                        Belum Checkin
                    @break

                    @case(1)
                        Tunggu Pendaftaran
                    @break

                    @case(2)
                        Proses Pendaftaran
                    @break

                    @case(3)
                        Tunggu Poliklinik
                    @break

                    @case(4)
                        Pemeriksaan Dokter
                    @break

                    @case(5)
                        Tunggu Farmasi
                    @break

                    @case(6)
                        Proses Farmasi
                    @break

                    @case(7)
                        Selesai Pelayanan
                    @break

                    @case(99)
                        Batal
                    @break

                    @default
                @endswitch
            </div>
            <x-adminlte-card theme="primary" theme-mode="outline">
                @include('sim.antrian_profil3')
                <x-slot name="footerSlot">
                    <x-adminlte-button class="btn-xs btnIcare" theme="warning" label="I-Care JKN"
                        icon="fas fa-info-circle" />
                    <x-adminlte-button class="btn-xs" theme="warning" label="Berkas Upload" icon="fas fa-file-medical" />
                </x-slot>
            </x-adminlte-card>
        </div>
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 600px ;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        {{-- riwayatpasien --}}
                        @include('sim.tabel_riwayat_pasien')
                        {{-- filepenunjang --}}
                        @include('sim.tabel_filepenunjang')
                        {{-- perawat --}}
                        @include('sim.tabel_anamnesa_perawat')
                        {{-- layanan --}}
                        @include('sim.tabel_layanan')
                        {{-- laboratorium --}}
                        @if ($antrian->kunjungan->layanan)
                            @if ($antrian->kunjungan->layanan->laboratorium)
                                @include('sim.tabel_lab')
                            @endif
                        @endif
                        {{-- resume --}}
                        <div class="card card-info mb-1">
                            <div class="card-header" role="tab" id="headRad">
                                <h3 class="card-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collResume"
                                        aria-expanded="true" aria-controls="collResume">
                                        Preview Resume
                                    </a>
                                </h3>
                            </div>
                            <div id="collResume" class="collapse" role="tabpanel" aria-labelledby="headRad">
                                <div class="card-body">
                                    @if ($kunjungan)
                                        @if ($kunjungan->asesmendokter)
                                            <div id="printMe">
                                                @include('form.asesmen_dokter_rajal')
                                            </div>
                                        @else
                                            <x-adminlte-alert title="Belum dilakukan asesmen dokter" theme="danger">
                                                Silahkan lakukan asesmen dokter
                                            </x-adminlte-alert>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('antrianperawat') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
                        class="btn btn-success mb-2 mr-1 withLoad">
                        <i class="fas fa-arrow-left"></i> Selesai & Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="modalICare" name="modalICare" title="I-Care JKN" theme="warning" icon="fas fa-file-medical"
        size="xl">
        <iframe src="" id="urlIcare" width="100%" height="500px" frameborder="0"></iframe>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalFileUpload" name="modalFileUpload" title="File Upload" theme="warning"
        icon="fas fa-file-medical" size="xl">
        @php
            $heads = ['Kunjungan', 'Pasien', 'Nama', 'Label', 'Action'];
            $config['paging'] = false;
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tabelRiwayat" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
            hoverable compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.BsCustomFileInput', true)
@section('js')
    {{-- dynamic layanan input --}}
    <script>
        $(".cariLayanan").select2({
            placeholder: 'Pencarian Pelayanan',
            theme: "bootstrap4",
            multiple: true,
            maximumSelectionLength: 1,
            ajax: {
                url: "{{ route('ref_tarif_layanan') }}?jenispasien={{ $antrian->jenispasien }}",
                type: "get",
                dataType: 'json',
                delay: 100,
                data: function(params) {
                    return {
                        search: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $("#addLayanan").click(function() {
            newRowAdd =
                '<div id="row"><div class="form-group"><div class="input-group input-group-sm">' +
                '<select name="layanan[]" class="form-control cariLayanan"></select>' +
                '<input type="number" name="jumlah[]" placeholder="Jumlah" class="form-control" multiple>' +
                '<button type="button" class="btn btn-xs btn-danger" id="deleteLayanan"><i class="fas fa-trash "></i> </div></div></div>';
            $('#newLayanan').append(newRowAdd);
            $(".cariLayanan").select2({
                placeholder: 'Pencarian Pelayanan',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('ref_tarif_layanan') }}?jenispasien={{ $antrian->jenispasien }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        });
        $("body").on("click", "#deleteLayanan", function() {
            $(this).parents("#row").remove();
        })
        $('.btnIcare').click(function() {
            $.LoadingOverlay("show");
            var url =
                "{{ route('icare') }}?nomorkartu={{ $antrian->nomorkartu }}&kodedokter={{ $antrian->kodedokter }}";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        console.log(data);
                        // $('#dataFilePenunjang').attr('src', $(this).data('fileurl'));
                        // $('#urlFilePenunjang').attr('href', $(this).data('fileurl'));
                        $('#modalICare').modal('show');
                    } else {
                        Swal.fire(
                            'Error ' + data.metadata.code,
                            data.metadata.message,
                            'error'
                        );
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    alert('Error');
                    $.LoadingOverlay("hide");
                }
            });
        });
    </script>
    <script>
        $(function() {
            $('.btnFilePenunjang').click(function() {
                $('#dataFilePenunjang').attr('src', $(this).data('fileurl'));
                $('#urlFilePenunjang').attr('href', $(this).data('fileurl'));
                $('#modalFilePenunjang').modal('show');
            });
        });
    </script>
@endsection
