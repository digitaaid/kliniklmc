@extends('adminlte::page')
@section('title', 'Layanan Keuangan')
@section('content_header')
    <h1>Layanan Keuangan</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" theme-mode='outline'>
                <div class="row">
                    <div class="col-md-4">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                        $config = ['format' => 'YYYY-MM-DD'];
                                    @endphp
                                    <x-adminlte-input-date name="tanggal"
                                        value="{{ $request->tanggal ?? now()->format('Y-m-d') }}"
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
                        'Tanggal',
                        'No',
                        'No RM',
                        'Nama Pasien',
                        'Jenis',
                        'SEP',
                        'Layanan',
                        'Obat',
                        'Diag Awal',
                        'Resume',
                    ];
                    $config['order'] = [[6, 'asc'], [7, 'asc']];
                    $config['paging'] = false;
                    $config['scrollX'] = true;
                    $config['scrollY'] = '300px';
                    $totallayanan = 0;
                    $totalobat = 0;
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable
                    compressed>
                    @if (isset($antrians))
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->kunjungan->tgl_masuk }}</td>
                                <td>A{{ $item->angkaantrean }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->jenispasien }} </td>
                                <td>{{ $item->sep }} </td>
                                <td class="text-right">
                                    @php
                                        $totallayanan = $totallayanan + $item->layanans?->sum('subtotal');
                                    @endphp
                                    {{ money($item->layanans?->sum('subtotal'), 'IDR') }}
                                    <x-adminlte-button icon="fas fa-edit" theme="warning" onclick="modalLayanan(this)"
                                        class="btn-xs" data-kode="{{ $item->kodebooking }}" />
                                    <x-adminlte-button icon="fas fa-file-invoice-dollar" theme="warning"
                                        onclick="modalInvoicePasien(this)" class="btn-xs"
                                        data-kodebooking="{{ $item->kodebooking }}" />
                                </td>
                                <td class="text-right">
                                    @php
                                        $totalobat = $totalobat + $item->resepdetails?->sum('subtotal');
                                    @endphp
                                    {{ money($item->resepdetails?->sum('subtotal'), 'IDR') }}
                                    <x-adminlte-button icon="fas fa-file-prescription" theme="warning"
                                        onclick="modalInvoicePasien(this)" class="btn-xs"
                                        data-kodebooking="{{ $item->kodebooking }}" />
                                </td>
                                <td>
                                    {{ $item->kunjungan->diagnosa_awal }}
                                </td>
                                <td>
                                    <x-adminlte-button class="btn-xs" theme="primary" label="Resume"
                                        icon="fas fa-file-medical" />
                                </td>
                            </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <th>Total Kunjungan</th>
                                <th>{{ $antrians->count() }}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Total Layanan</th>
                                <th class="text-right">{{ money($totallayanan, 'IDR') }}</th>
                                <th class="text-right">{{ money($totalobat, 'IDR') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    @endif

                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalAntrian" title="Pasien" icon="fas fa-user-injured" theme="success">
        <form action="{{ route('update_taksid_antrian') }}" id="formAntrian" name="formAntrian" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            @php
                $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date name="tanggalperiksa" label="Tgl Periksa" fgroup-class="row"
                label-class="text-left col-4" igroup-size="sm" igroup-class="col-8" :config="$config" required readonly>
            </x-adminlte-input-date>
            <x-adminlte-input name="kodebooking" label="Kodebooking" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" enable-old-support required readonly />
            <x-adminlte-input name="norm" label="No RM" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" enable-old-support required readonly />
            <x-adminlte-input name="nama" label="Nama" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" enable-old-support required readonly />
            <x-adminlte-input name="status" label="Status" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" enable-old-support required />
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <x-adminlte-input-date name="taskid1" label="Waktu Taskid1" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid2" label="Waktu Taskid2" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid3" label="Waktu Taskid3" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid4" label="Waktu Taskid4" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid5" label="Waktu Taskid5" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid6" label="Waktu Taskid6" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid7" label="Waktu Taskid7" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button form="formAntrian" class="mr-auto" type="submit" icon="fas fa-save" theme="success"
                label="Simpan" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalLayanan" size="xl" title="Layanan & Tindakan Pasien" icon="fas fa-pills"
        theme="warning">
        <div id="formLayanan">
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button class="btnTambahTarif" theme="success" label="Tambah" />
            <x-adminlte-button class="mr-auto btnUpdateTarif" theme="warning" label="Update" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalInvoicePasien" title="Invoice Billing Pasien" theme="success"
        icon="fas fa-file-invoice-dollar" size="xl">
        <div id="iframeLoaders" class="loader">
            <h4>Loading...</h4>
        </div>
        <iframe src="" id="urlInvoice" onload="loadInvoices()" width="100%" height="500px"
            frameborder="0"></iframe>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('js')

    <script>
        function editAntrian(button) {
            $.LoadingOverlay("show");
            $('#formAntrian').trigger("reset");
            $('#id').val($(button).data("id"));
            $('#tanggalperiksa').val($(button).data("tanggalperiksa"));
            $('#nama').val($(button).data("nama"));
            $('#norm').val($(button).data("norm"));
            $('#kodebooking').val($(button).data("kodebooking"));
            $('#status').val($(button).data("status"));
            $('#taskid1').val($(button).data("taskid1"));
            $('#taskid2').val($(button).data("taskid2"));
            $('#taskid3').val($(button).data("taskid3"));
            $('#taskid4').val($(button).data("taskid4"));
            $('#taskid5').val($(button).data("taskid5"));
            $('#taskid6').val($(button).data("taskid6"));
            $('#taskid7').val($(button).data("taskid7"));
            $('#modalAntrian').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
    <script>
        function modalLayanan(button) {
            $.LoadingOverlay("show");
            var url = "{{ route('form_layanan') }}?kode=" + $(button).data("kode");
            console.log(url);
            $.ajax({
                url: url,
                method: "GET",
            }).done(function(data) {
                console.log(data);
                $('#formLayanan').html(data);
                // $(".cariObat").select2({
                //     placeholder: 'Pencarian Nama Obat',
                //     theme: "bootstrap4",
                //     multiple: true,
                //     maximumSelectionLength: 1,
                //     ajax: {
                //         url: "{{ route('ref_obat_cari') }}",
                //         type: "get",
                //         dataType: 'json',
                //         delay: 100,
                //         data: function(params) {
                //             return {
                //                 nama: params.term // search term
                //             };
                //         },
                //         processResults: function(response) {
                //             return {
                //                 results: response
                //             };
                //         },
                //         cache: true
                //     }
                // });
                $('#modalLayanan').modal('show');
                $.LoadingOverlay("hide");
            }).fail(function(data, textStatus, errorThrown) {
                console.log(data);
                $.LoadingOverlay("hide");
            });
        }
    </script>
    {{-- toast --}}
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    </script>
    {{-- invoice --}}
    <script>
        function loadInvoices() {
            $('#iframeLoaders').hide();
            $('#urlInvoice').show();
        }

        function modalInvoicePasien(button) {
            $.LoadingOverlay("show");
            var url = "{{ route('print_invoice_billing') }}?kodebooking=" + $(button).data("kodebooking");
            $('#modalInvoicePasien').modal('show');
            $('#urlInvoice').attr('src', url);
            $('#iframeLoaders').show();
            $('#urlInvoice').hide();
            $.LoadingOverlay("hide");
        }
    </script>
@endsection
