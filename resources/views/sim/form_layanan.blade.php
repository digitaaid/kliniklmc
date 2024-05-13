<div class="row">
    <div class="col-md-12">
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
            <tbody>
                @foreach ($antrian->layanans as $layanan)
                    <tr>
                        <td>{{ $layanan->tgl_input }}</td>
                        <td>{{ $layanan->nama }}</td>
                        <td>{{ $layanan->nama }}</td>
                        <td>{{ $layanan->jaminans->nama }}</td>
                        <td>{{ $layanan->pic->name }}</td>
                        <td class="text-right">{{ money($layanan->harga, 'IDR') }} x {{ $layanan->jumlah }}</td>
                        <td>{{ $layanan->diskon }}</td>
                        <td class="text-right">{{ money($layanan->subtotal, 'IDR') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7">Total</th>
                    <th class="text-right">{{ money($antrian->layanans?->sum('subtotal') ?? 0, 'IDR') }}</th>
                </tr>
            </tfoot>
        </table>
        <hr>
    </div>
    <div class="col-md-12">
        <form name="formInputTarif" id="formInputTarif">
            <div class="row">
                @csrf
                <input type="hidden" name="kodekunjungan" value="{{ $antrian->kunjungan->kode }}">
                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id }}">
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <div class="col-md-6">
                    <x-adminlte-input name="norm" fgroup-class="row" label-class="text-left col-3"
                        igroup-class="col-9" igroup-size="sm" label="No RM" value="{{ $antrian->norm }}" readonly />
                    <x-adminlte-input name="nama" fgroup-class="row" label-class="text-left col-3"
                        igroup-class="col-9" igroup-size="sm" label="Nama" value="{{ $antrian->nama }}" readonly />
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" name="layanan" id="layanantarif" class="layanan_tarif" label="Layanan"
                        multiple>
                    </x-adminlte-select>
                    <x-adminlte-input id="harga-tarif" name="harga" type="number" label="Harga" fgroup-class="row"
                        label-class="text-left col-3" igroup-class="col-9" igroup-size="sm" placeholder="Harga" />
                    <x-adminlte-input id="jumlah-tarif" name="jumlah" type="number" label="Jumlah" fgroup-class="row"
                        label-class="text-left col-3" igroup-class="col-9" igroup-size="sm" placeholder="Jumlah" />
                    <x-adminlte-input id="diskon-tarif" name="diskon" type="number" label="Diskon" fgroup-class="row"
                        label-class="text-left col-3" igroup-class="col-9" igroup-size="sm" placeholder="Diskon" />
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" name="jaminan" label="Jaminan">
                        <option selected disabled>Pilih Jaminan</option>
                        @foreach ($jaminans as $key => $item)
                            <option value="{{ $key }}"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->jaminan == $key ? 'selected' : null) : null }}>
                                {{ $item }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    $(function() {
        $(".diagnosaid2").select2({
            theme: "bootstrap4",
            ajax: {
                url: "{{ route('ref_icd10_api') }}",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        diagnosa: params.term // search term
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
            console.log($("#formInputTarif").serialize());
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
                    console.log(data);
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
                url: "{{ route('update_tarif_pasien') }}",
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
        refresTableLayanan();
    });

    function refresTableLayanan() {
        var url = "{{ route('get_layanan_kunjungan') }}?kunjungan={{ $antrian->kunjungan->id }}";
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
                        value.pic ? value.pic.name : value.user,
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
                    // $('.btnUpdateTarif').show();
                    // $('.btnTambahTarif').show();
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
    $(() => {
        let usrCfgtglperiksa = _AdminLTE_InputDate.parseCfg({
            "format": "YYYY-MM-DD",
            "icons": {
                "time": "fas fa-clock",
                "date": "fas fa-calendar-alt",
                "up": "fas fa-arrow-up",
                "down": "fas fa-arrow-down",
                "previous": "fas fa-chevron-left",
                "next": "fas fa-chevron-right",
                "today": "fas fa-calendar-check-o",
                "clear": "fas fa-trash",
                "close": "fas fa-times"
            },
            "buttons": {
                "showClose": true
            }
        });
        $('#tanggalperiksa').datetimepicker(usrCfgtglperiksa);
        let usrCfgtglmasuk = _AdminLTE_InputDate.parseCfg({
            "format": "YYYY-MM-DD HH:mm:ss",
            "icons": {
                "time": "fas fa-clock",
                "date": "fas fa-calendar-alt",
                "up": "fas fa-arrow-up",
                "down": "fas fa-arrow-down",
                "previous": "fas fa-chevron-left",
                "next": "fas fa-chevron-right",
                "today": "fas fa-calendar-check-o",
                "clear": "fas fa-trash",
                "close": "fas fa-times"
            },
            "buttons": {
                "showClose": true
            }
        });
        $('#tgl_masuk').datetimepicker(usrCfgtglmasuk);
    })
</script>
