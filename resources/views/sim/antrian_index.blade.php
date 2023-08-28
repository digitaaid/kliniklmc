@extends('adminlte::page')
@section('title', 'Antrian Pasien')
@section('content_header')
    <h1>Antrian Pasien</h1>
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
                            <x-adminlte-input-date name="tanggalperiksa" label="Tanggal Laporan"
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
                <x-adminlte-card title="Data Antrian" theme="primary" icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['No Antrian', 'kodebooking', 'Pasien', 'Dokter', 'Poliklinik', 'Jenis Pasien', 'Status', 'Action'];
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" bordered hoverable compressed>
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->nomorantrean }} / {{ $item->angkaantrean }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->norm }} {{ $item->nama }}</td>
                                <td>{{ $item->namadokter }}</td>
                                <td>{{ $item->namapoli }}</td>
                                <td>{{ $item->pasienbaru }} {{ $item->jenispasien }} </td>
                                <td>{{ $item->taskid }}</td>
                                <td>
                                    <button class="btn btn-xs btn-success btnAntrian"
                                        data-kodebooking="{{ $item->kodebooking }}" data-taskid="{{ $item->taskid }}">
                                        Layani
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        @endif
    </div>
    <x-adminlte-modal id="modalAntrian" title="Antrian Pasien" icon="fas fa-user" theme="success" v-centered>
        <x-slot name="footerSlot">
            <a href="" class="btn btn-warning mr-auto" id="btnLanjutPoli"><i class="fas fa-sign"></i> Lanjut
                Poliklinik</a>
            <a href="" class="btn btn-danger" id="btnBatal"><i class="fas fa-times"></i> Batal</a>
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)

@section('js')
    <script>
        $(function() {
            $('.btnAntrian').click(function() {
                $.LoadingOverlay("show");
                var kodebooking = $(this).data("kodebooking");
                var taskid = $(this).data("taskid");
                var url = "{{ route('layanipendaftaran') }}?kodebooking=" + kodebooking;
                if (taskid == 1) {
                    $.get(url, function(data, status) {
                        console.log(data);
                    });
                }
                var urllanjut = "{{ route('lanjutpoliklinik') }}?kodebooking=" + kodebooking;
                $("#btnLanjutPoli").attr("href", urllanjut);
                var urlbatal = "{{ route('batalantrian') }}?kodebooking=" + kodebooking +
                    "&keterangan=dibatalkan_dipendaftarn";
                $("#btnBatal").attr("href", urlbatal);
                $('#modalAntrian').modal('show');
                $.LoadingOverlay("hide");
            });
        });
    </script>

@endsection
