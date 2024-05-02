<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collLay" aria-expanded="true"
        aria-controls="collLay">
        <h3 class="card-title">
            Layanan & Tindakan
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool bg-success">
                <i class="fas fa-hand-holding-medical"></i> {{ $antrian->layanans->count() }} Layanan
            </button>
        </div>
    </a>
    <div id="collLay" class="show collapse" role="tabpanel">
        <div class="card-body">
            <button type="button" class="btn btn-xs btn-success mb-2" onclick="tambahLayanan()">
                <i class="fas fa-plus"></i> Tambah Layanan
            </button>
            <button type="button" class="btn btn-xs btn-success mb-2 getLayananKunjungan">
                <i class="fas fa-sync"></i> Refresh Layanan
            </button>
            @php
                $heads = [
                    'Tgl Input',
                    'Action',
                    'Layanan/Tindakan',
                    'Jaminan',
                    'PIC',
                    'Harga @ Jumlah',
                    'Diskon',
                    'Subtotal',
                ];
                $config['paging'] = false;
                $config['searching'] = true;
                $config['info'] = false;
                $config['bLengthChange'] = false;
                $config['scrollX'] = true;
            @endphp
            <table id="tableLayanans" class="table table-bordered table-hover table-sm nowrap text-xs w-100">
                <thead>
                    <tr>
                        <th>Tgl Input</th>
                        <th>Action</th>
                        <th>Layanan/Tindakan</th>
                        <th>Jaminan</th>
                        <th>PIC</th>
                        <th>Harga @ Jumlah</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
            </table>
            {{-- <x-adminlte-datatable id="tableLayanans" class="nowrap text-xs" :config="$config" :heads="$heads" bordered
                hoverable compressed>
            </x-adminlte-datatable> --}}
        </div>
    </div>
</div>
<x-adminlte-modal id="modalTarif" name="modalTarif" title="Tarif Layanan & Tindakan" theme="success"
    icon="fas fa-user-injured" size="xl">
    <form name="formInputTarif" id="formInputTarif">
        <div class="row">
            @csrf
            <input type="hidden" name="kodekunjungan" value="{{ $antrian->kodekunjungan }}">
            <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan_id }}">
            <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
            <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
            <input type="hidden" name="norm" value="{{ $antrian->norm }}">
            <input type="hidden" name="nama" value="{{ $antrian->nama }}">
            <div class="col-md-6">
                <x-adminlte-select igroup-size="sm" name="layanan" id="layanantarif" class="layanan_tarif"
                    label="Layanan & Tindalan :" multiple>
                </x-adminlte-select>
                <x-adminlte-input id="harga-tarif" name="harga" type="number" label="Harga" igroup-size="sm"
                    placeholder="Harga" readonly />
                <x-adminlte-input id="jumlah-tarif" name="jumlah" type="number" label="Jumlah" igroup-size="sm"
                    placeholder="Jumlah" />
                <x-adminlte-input id="diskon-tarif" name="diskon" type="number" label="Diskon" igroup-size="sm"
                    placeholder="Diskon" />
            </div>
            <div class="col-md-6">
                <x-adminlte-select igroup-size="sm" name="jaminan" label="Jaminan Pasien">
                    <option selected disabled>Pilih Jaminan</option>
                    @foreach ($jaminans as $key => $item)
                        <option value="{{ $key }}"
                            {{ $antrian->kunjungan ? ($antrian->kunjungan->jaminan == $key ? 'selected' : null) : null }}>
                            {{ $item }}</option>
                    @endforeach
                </x-adminlte-select>

            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto btnTambahTarif" theme="success" label="Tambah" />
        <x-adminlte-button class="mr-auto btnUpdateTarif" theme="warning" label="Update" />
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    <script>
        $(function() {
            $("#layanantarif").select2({
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                placeholder: "Tarif & Layanan",
                ajax: {
                    url: "{{ route('ref_tarif_layanan') }}?jenispasien={{ $antrian->jenispasien }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
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
            $('.layanan_tarif').on('select2:select', function(e) {
                var data = e.params.data;
                $("#jumlah-tarif").val(1);
                $("#harga-tarif").val(e.params.data.harga);
                $("#diskon-tarif").val(0);
                console.log(data);
            });
            $('.btnTambahTarif').click(function() {
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    url: "{{ route('input_tarif_pasien') }}",
                    data: $("#formInputTarif").serialize(),
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    console.log(data);
                    if (data.metadata.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarif layanan & tindakan telah ditambahkan',
                        });
                        $("#formInputTarif").trigger('reset');
                        $(".layanan_tarif").val(null).change();
                        refresTableLayanan();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Tambah tarif layanan & tindakan error',
                        });
                    }
                    $.LoadingOverlay("hide");
                });
            });
            $('.btnUpdateTarif').click(function() {
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    url: "{{ route('input_tarif_pasien') }}",
                    data: $("#formInputTarif").serialize(),
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    console.log(data);
                    if (data.metadata.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarif layanan & tindakan telah ditambahkan',
                        });
                        $("#formInputTarif").trigger('reset');
                        $(".layanan_tarif").val(null).change();
                        refresTableLayanan();
                        $('#modalTarif').modal('hide');
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Tambah tarif layanan & tindakan error',
                        });
                    }
                    $.LoadingOverlay("hide");
                });
            });
            $('.getLayananKunjungan').click(function() {
                refresTableLayanan();
            });
            refresTableLayanan();
        });
        function refresTableLayanan() {
            var url = "{{ route('get_layanan_kunjungan') }}?kunjungan={{ $antrian->kunjungan_id }}";
            if ($.fn.dataTable.isDataTable('#tableLayanans')) {
                $('#tableLayanans').DataTable().destroy();
            }
            var table = $('#tableLayanans').DataTable({
                paging: false,
                scrollX: false,
            });
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                table.rows().remove().draw();
                if (data.metadata.code == 200) {
                    $.each(data.response, function(key, value) {
                        console.log(value);
                        var btn =
                            '<button class="btn btn-xs btn-warning btnEditTarif" data-nama="' +
                            value.nama + '" data-tarifid="' + value.tarif_id +
                            '" data-harga="' +
                            value.harga +
                            '" data-jumlah="' +
                            value.jumlah +
                            '" data-diskon="' +
                            value.diskon +
                            '"><i class="fas fa-edit"></i></button> <button class="btn btn-xs btn-danger btnHapusTarif" data-id="' +
                            value.id +
                            '"><i class="fas fa-trash"></i></button>';
                        table.row.add([
                            value.tgl_input,
                            btn,
                            value.nama,
                            value.jaminans.nama,
                            value.pic,
                            'Rp ' + value.harga.toLocaleString() + ' @ ' + value.jumlah,
                            value.diskon + ' %',
                            'Rp ' + (value.subtotal).toLocaleString(),
                        ]).draw(false);
                    });
                    $('.btnEditTarif').click(function() {
                        $("#formInputTarif").trigger('reset');
                        var option = new Option($(this).data('nama'), $(this).data('tarifid'));
                        option.selected = true;
                        $(".layanan_tarif").append(option);
                        $(".layanan_tarif").trigger("change");
                        $('.btnUpdateTarif').show();
                        $('.btnTambahTarif').hide();
                        $("#jumlah-tarif").val($(this).data('jumlah'));
                        $("#harga-tarif").val($(this).data('harga'));
                        $("#diskon-tarif").val($(this).data('diskon'));
                        $('#modalTarif').modal('show');
                    });
                    $('.btnHapusTarif').click(function() {
                        $.LoadingOverlay("show");
                        $.ajax({
                            type: "POST",
                            url: "{{ route('delete_tarif_pasien') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "tarif": tarif = $(this).data('id')
                            },
                            dataType: "json",
                            encode: true,
                        }).done(function(data) {
                            console.log(data);
                            if (data.metadata.code == 200) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Tarif layanan & tindakan telah dihapuskan',
                                });
                                $("#formInputTarif").trigger('reset');
                                $(".layanan_tarif").val(null).change();
                                refresTableLayanan();
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Tarif layanan & tindakan gagal dihapuskan',
                                });
                            }
                            $.LoadingOverlay("hide");
                        });
                        $.LoadingOverlay("hide");
                    });
                } else {
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    );
                }
            });
        }
    </script>
    <script>
        function tambahLayanan() {
            $('.btnUpdateTarif').hide();
            $('.btnTambahTarif').show();
            $("#formInputTarif").trigger('reset');
            $(".layanan_tarif").val(null).change();
            $('#modalTarif').modal('show');
        }
    </script>
@endpush
