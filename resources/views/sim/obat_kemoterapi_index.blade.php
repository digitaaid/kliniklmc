@extends('adminlte::page')

@section('title', 'Resep Obat Kemoterapi')

@section('content_header')
    <h1>Resep Obat Kemoterapi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Resep Obat Kemoterapi" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['Waktu', 'Kode', 'No RM', 'Nama Pasien', 'Regimen', 'PIC', 'Kunjungan', 'Status', 'Action'];
                    $config['order'] = [1, 'asc'];
                    $config['paging'] = false;
                    $config['scrollY'] = '500px';
                @endphp
                <x-adminlte-button id="btnTambah" class="btn-sm mb-2" theme="success" label="Tambah Obat" icon="fas fa-plus" />
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($reseps as $item)
                        <tr>
                            <td>{{ $item->waktu }}</td>
                            <td>{{ $item->kode }}</td>

                            <td>{{ $item->norm }}</td>
                            <td>{{ $item->nama }}</td>

                            <td>{{ $item->regimen }}</td>
                            <td>{{ $item->pic ? $item->pic->name : $item->user }}</td>
                            <td>
                                @if ($item->kunjungan_id)
                                    <span class="badge badge-success">Terintegrasi</span>
                                @else
                                    <span class="badge badge-danger">Belum Terintegrasi</span>
                                @endif
                            </td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" label="Edit" theme="warning" icon="fas fa-edit"
                                    title="Edit Resep Kemterapi {{ $item->nama }}" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}" data-kode="{{ $item->kode }}"
                                    data-waktu="{{ $item->waktu }}" data-norm="{{ $item->norm }}"
                                    data-diagnosa="{{ $item->diagnosa }}" data-kunjungan_id="{{ $item->kunjungan_id }}"
                                    data-kodekunjungan="{{ $item->kodekunjungan }}" data-regimen="{{ $item->regimen }}" />
                                <a href="{{ route('print_resepkemoterapi') }}?kode={{ $item->kode }}"
                                    class="btn btn-xs btn-success" target="_blank"> <i class="fas fa-print"></i>
                                    Print</a>
                            </td>
                        </tr>
                    @endforeach
                    {{-- @foreach ($obats as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ $item->jenisobat }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" icon="fas fa-edit"
                                    title="Edit Obat {{ $item->nama }}" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}" />
                            </td>
                        </tr>
                    @endforeach --}}
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalObat" title="Resep Obat Kemoterapi" size='xl' icon="fas fa-pills" theme="success"
        static-backdrop scrollable>
        <form action="" id="formObat" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <input type="hidden" name="kode" id="kode">
            <div class="row">
                <div class="col-md-6">
                    @php
                        $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                    @endphp
                    <x-adminlte-input-date name="waktu" value="{{ now() }}" label="Tanggal / Waktu"
                        placeholder="Waktu Pelayanan" :config="$config" igroup-size="sm" enable-old-support required />
                    <input type="hidden" id="kunjungan_id" name="kunjungan_id">
                    <x-adminlte-input name="kodekunjungan" label="Kode Kunjungan" placeholder="Kode Kunjungan"
                        igroup-size="sm" enable-old-support required readonly>
                        <x-slot name="appendSlot">
                            <div class="btn btn-warning btnCariKunjungan"><i class="fas fa-search"></i> Cari
                                Kunjungan</div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="nama" label="Nama Pasien" placeholder="Nama Pasien" igroup-size="sm"
                        enable-old-support required />
                    <x-adminlte-input name="norm" label="No RM" placeholder="No RM" igroup-size="sm" enable-old-support
                        required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="diagnosa" label="Diagnosa" placeholder="Diagnosa" igroup-size="sm"
                        enable-old-support required />
                    <x-adminlte-input name="regimen" label="Regimen" placeholder="Regimen" igroup-size="sm"
                        enable-old-support required />
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    Permintaan Obat Kemoterapi
                    @foreach ($obatkemoterapi as $item)
                        <div class="row">
                            <input type="hidden" name="obat[]" value="{{ $item->id }}" multiple>
                            <x-adminlte-input name="namaobat[]" value="{{ $item->nama }}" igroup-size="sm" multiple
                                readonly />
                            <x-adminlte-input name="jumlah[]" type="number" id="obat{{ $item->id }}"
                                placeholder="Jumlah" igroup-size="sm" multiple />
                        </div>
                    @endforeach
                </div>
                <div class="col-md-6">
                    Penunjang Obat Kemoterapi
                    @foreach ($penunjangkemoterapi as $item)
                        <div class="row">
                            <input type="hidden" name="obat[]" value="{{ $item->id }}" multiple>
                            <x-adminlte-input name="namaobat[]" value="{{ $item->nama }}" igroup-size="sm" multiple
                                readonly />
                            <x-adminlte-input name="jumlah[]" type="number" id="obat{{ $item->id }}"
                                placeholder="Jumlah" igroup-size="sm" multiple />
                        </div>
                    @endforeach
                </div>
            </div>
        </form>
        <form id="formDelete" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button id="btnStore" class="mr-auto" type="submit" icon="fas fa-save" theme="success"
                label="Simpan" />
            <x-adminlte-button id="btnUpdate" class="mr-auto" type="submit" icon="fas fa-edit" theme="warning"
                label="Update" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalKunjungan" name="modalKunjungan" title="Kunjungan Pasien" theme="success"
        icon="fas fa-file-medical" size="xl">
        @php
            $heads = ['Tgl Masuk', 'Kode', 'No RM', 'Nama Pasien', 'Action'];
            $config['paging'] = false;
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableKunjungan" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
            hoverable compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
    <script>
        $(function() {
            $('#btnTambah').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').show();
                $('#btnUpdate').hide();
                $('#formObat').trigger("reset");
                $('#modalObat').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formObat').trigger("reset");
                // get
                $('#id').val($(this).data("id"));
                $('#kode').val($(this).data("kode"));
                $('#kunjungan_id').val($(this).data("kunjungan_id"));
                $('#kodekunjungan').val($(this).data("kodekunjungan"));
                $('#nama').val($(this).data("nama"));
                $('#norm').val($(this).data("norm"));
                $('#diagnosa').val($(this).data("diagnosa"));
                $('#regimen').val($(this).data("regimen"));
                $('#waktu').val($(this).data("waktu"));
                var url = "{{ route('get_resepkemoterapi') }}?kode=" + $(this).data("kode");
                $.get(url, function(data) {
                    console.log(data);
                    data.response.forEach(obat => {
                        $('#obat' + obat.obat_id).val(obat.jumlah);

                    });
                    // alert("Load was performed.");
                });

                $('#modalObat').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('store_resepkemoterapi') }}";
                $('#formObat').attr('action', url);
                $("#method").prop('', true);
                $('#formObat').submit();

            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('store_resepkemoterapi') }}";
                $('#formObat').attr('action', url);
                $('#method').val('POST');
                $('#formObat').submit();
            });
            $('.btnCariKunjungan').click(function(e) {
                var waktukunjungan = $("#waktu").val();
                $('#modalKunjungan').modal('show');
                var table = $('#tableKunjungan').DataTable();
                table.rows().remove().draw();
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('kunjunganwaktu') }}?waktu=" + waktukunjungan;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $.each(data.response, function(key, value) {
                                var btnpilih =
                                    "<button class='btnPilihKunjungan btn btn-success btn-xs' data-id=" +
                                    value.id + " data-kode=" +
                                    value.kode +
                                    " data-nama=" + value.nama + " data-norm=" + value
                                    .norm + "  >Pilih</button>";
                                table.row.add([
                                    value.tgl_masuk,
                                    value.kode,
                                    value.norm,
                                    value.nama,
                                    btnpilih,
                                ]).draw(false);

                            });
                            $('.btnPilihKunjungan').click(function() {
                                $.LoadingOverlay("show");
                                $('#kodekunjungan').val($(this).data('kode'));
                                $('#kunjungan_id').val($(this).data('id'));
                                $('#nama').val($(this).data('nama'));
                                $('#norm').val($(this).data('norm'));
                                $('#modalKunjungan').modal('hide');
                                $.LoadingOverlay("hide");
                            });
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
            // $('.btnDelete').click(function(e) {
            //     e.preventDefault();
            //     var name = $(this).data("name");
            //     swal.fire({
            //         title: 'Apakah anda ingin menghapus user ' + name + ' ?',
            //         showConfirmButton: false,
            //         showDenyButton: true,
            //         showCancelButton: true,
            //         denyButtonText: `Ya, Hapus`,
            //     }).then((result) => {
            //         if (result.isDenied) {
            //             $.LoadingOverlay("show");
            //             var id = $(this).data("id");
            //             var url = "{{ route('obat.index') }}/" + id;
            //             $('#formDelete').attr('action', url);
            //             $('#formDelete').submit();
            //         }
            //     })
            // });
        });
    </script>
@endsection
