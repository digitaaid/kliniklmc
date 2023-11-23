@extends('adminlte::page')
@section('title', 'Pasien')
@section('content_header')
    <h1>Pasien</h1>
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
            <x-adminlte-card title="Data Pasien" theme="primary" icon="fas fa-info-circle" collapsible>
                <div class="row">
                    <div class="col-md-8">
                        <x-adminlte-button id="btnTambah" class="btn-sm" theme="success" label="Tambah Pasien"
                            icon="fas fa-plus" />
                        <a href="{{ route('pasienexport') }}" class="btn btn-sm btn-primary"><i class="fas fa-print"></i>
                            Export</a>
                        <div class="btn btn-sm btn-primary btnModalImport"><i class="fas fa-file-medical"></i> Import</div>
                    </div>
                    <div class="col-md-4">
                        <form action="" method="get">
                            <x-adminlte-input name="search" placeholder="Pencarian NIK / Nama" igroup-size="sm"
                                value="{{ $request->search }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="outline-primary" label="Cari" />
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
                    $heads = ['No RM', 'No BPJS', 'NIK', 'Nama Pasien', 'Gender', 'Tgl Lahir', 'Status', 'Action'];
                    $config['order'] = [0, 'desc'];
                    $config['paging'] = false;
                    $config['lengthMenu'] = false;
                    $config['searching'] = false;
                    $config['info'] = false;
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($pasiens as $item)
                        <tr>
                            <td>{{ $item->norm }}</td>
                            <td>{{ $item->nomorkartu }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ $item->tgl_lahir }} ({{ Carbon\Carbon::parse($item->tgl_lahir)->age }} tahun) </td>
                            <td>
                                @if ($item->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Non-Aktif</span>
                                @endif
                            </td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" label="Edit" icon="fas fa-edit"
                                    title="Edit Pasien {{ $item->nama }}" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}" data-nohp="{{ $item->nohp }}"
                                    data-gender="{{ $item->gender }}" data-tempat_lahir="{{ $item->tempat_lahir }}"
                                    data-tgl_lahir="{{ $item->tgl_lahir }}" data-nik="{{ $item->nik }}"
                                    data-nomorkartu="{{ $item->nomorkartu }}" data-norm="{{ $item->norm }}"
                                    data-alamat="{{ $item->alamat }}" data-created="{{ $item->created_at }}"
                                    data-updated="{{ $item->updated_at }}" data-jenispeserta="{{ $item->jenispeserta }}"
                                    data-hakkelas="{{ $item->hakkelas }}" data-fktp="{{ $item->fktp }}"
                                    data-user="{{ $item->pic ? $item->pic->name : $item->user }}" />
                                <a href="{{ route('riwayatpasien') }}?norm={{ $item->norm }}"
                                    class="btn btn-xs btn-primary"><i class="fas fa-file-medical"></i> Riwayat</a>
                                <x-adminlte-button class="btn-xs btnDelete" theme="danger" icon="fas fa-trash-alt"
                                    title="Non-Aktifkan Pasien {{ $item->name }} " data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}" />
                                <x-adminlte-button class="btn-xs" theme="secondary" label="PIC" icon="fas fa-user"
                                    title="PIC {{ $item->pic ? $item->pic->name : $item->user }} {{ $item->updated_at }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
                <div class="row">
                    <div class="col-md-5">
                        Tampil data {{ $pasiens->firstItem() }} sampai {{ $pasiens->lastItem() }} dari total
                        {{ $total_pasien }}
                    </div>
                    <div class="col-md-7">
                        <div class="float-right pagination-sm">
                            {{ $pasiens->links() }}
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalPasien" title="Pasien" size="xl" icon="fas fa-user-injured" theme="success">
        <form action="" id="formPasien" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="norm" label="No RM" placeholder="No RM" enable-old-support />
                    <x-adminlte-input name="nik" label="NIK" placeholder="NIK" enable-old-support>
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary btnCariNIK">
                                <i class="fas fa-sync"></i> Sync
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="nomorkartu" label="No BPJS" placeholder="no BPJS" enable-old-support>
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary btnCariKartu">
                                <i class="fas fa-sync"></i> Sync
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="nama" label="Nama Lengkap" placeholder="Nama Lengkap" enable-old-support
                        required />
                    <x-adminlte-input name="nohp" label="No HP" placeholder="No HP" enable-old-support />
                    <x-adminlte-select name="gender" label="Jenis Kelamin">
                        <option selected disabled>Jenis Kelamin</option>
                        <option value="P">Perempuan</option>
                        <option value="L">Laki-Laki</option>
                    </x-adminlte-select>
                    <x-adminlte-select2 name="tempat_lahir" label="Tempat Lahir">
                    </x-adminlte-select2>
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tgl_lahir" label="Tanggal Lahir" placeholder="Pilih Tanggal Lahir"
                        :config="$config">
                    </x-adminlte-input-date>
                </div>
                <div class="col-md-6">
                    <x-adminlte-select name="hakkelas" label="Hak Kelas">
                        <option selected disabled>Hak Kelas</option>
                        <option value="1">Kelas 1</option>
                        <option value="2">Kelas 2</option>
                        <option value="3">Kelas 3</option>
                    </x-adminlte-select>
                    <x-adminlte-input name="jenispeserta" label="Jenis Peserta" placeholder="Jenis Peserta"
                        enable-old-support />
                    <x-adminlte-input name="fktp" label="FKTP" placeholder="Faskes Tingkat Pertama"
                        enable-old-support />
                    <x-adminlte-textarea igroup-size="sm" rows=4 label="Alamat" name="alamat" placeholder="Alamat">
                    </x-adminlte-textarea>
                    <p>
                        <b>PIC : </b>
                        <span id='user'></span><br>
                        <b>Waktu diperbaharui : </b>
                        <span id='updated'></span><br>
                        <b>Waktu didaftarkan : </b>
                        <span id='created'></span><br>
                    </p>
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
    <x-adminlte-modal id="modalImport" title="Import Pasien" icon="fas fa-user-injured" theme="success" static-backdrop>
        <form action="{{ route('pasienimport') }}" id="formImport" name="formImport" method="POST"
            enctype="multipart/form-data">
            @csrf
            <x-adminlte-input-file name="file" placeholder="Pilih file Import" igroup-size="sm"
                label="File Import Obat" />
            <x-slot name="footerSlot">
                <x-adminlte-button form="formImport" class="mr-auto withLoad" type="submit" icon="fas fa-save"
                    theme="success" label="Import" />
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.BsCustomFileInput', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $(function() {
            $('#btnTambah').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').show();
                $('#btnUpdate').hide();
                $('#formPasien').trigger("reset");
                $('#modalPasien').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formPasien').trigger("reset");
                // get
                $('#id').val($(this).data("id"));
                $('#nama').val($(this).data("nama"));
                $('#norm').val($(this).data("norm"));
                $('#nik').val($(this).data("nik"));
                $('#nomorkartu').val($(this).data("nomorkartu"));
                $('#nohp').val($(this).data("nohp"));
                $('#tgl_lahir').val($(this).data("tgl_lahir"));
                $('#alamat').val($(this).data("alamat"));
                $("#jenispeserta").val($(this).data("jenispeserta"));
                $("#fktp").val($(this).data("fktp"));
                $("#hakkelas").val($(this).data("hakkelas")).change();
                $('#gender').val($(this).data("gender")).change();
                $('#user').html($(this).data("user"));
                $('#updated').html($(this).data("updated"));
                $('#created').html($(this).data("created"));
                if ($(this).data("tempat_lahir")) {
                    $('#tempat_lahir').append('<option selected value="' + $(this).data("tempat_lahir") +
                        '">' + $(
                            this).data("tempat_lahir") + '</option>');
                }

                $('#modalPasien').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('pasien.store') }}";
                $('#formPasien').attr('action', url);
                $("#method").prop('', true);
                $('#formPasien').submit();

            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('pasien.index') }}/" + id;
                $('#formPasien').attr('action', url);
                $('#method').val('PUT');
                $('#formPasien').submit();
            });
            $('.btnModalImport').click(function() {
                $.LoadingOverlay("show");
                $('#modalImport').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnDelete').click(function(e) {
                e.preventDefault();
                var name = $(this).data("name");
                swal.fire({
                    title: 'Apakah anda ingin menonaktifkan pasien ' + name + ' ?',
                    showConfirmButton: false,
                    showDenyButton: true,
                    showCancelButton: true,
                    denyButtonText: `Ya, Non Aktifkan`,
                }).then((result) => {
                    if (result.isDenied) {
                        $.LoadingOverlay("show");
                        var id = $(this).data("id");
                        var url = "{{ route('pasien.index') }}/" + id;
                        $('#formDelete').attr('action', url);
                        $('#formDelete').submit();
                    }
                })
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
    <script>
        $(function() {
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
            $('.btnCariKartu').click(function() {
                $.LoadingOverlay("show");
                var nomorkartu = $("#nomorkartu").val();
                var url = "{{ route('peserta_nomorkartu') }}?nomorkartu=" + nomorkartu +
                    "&tanggal={{ now()->format('Y-m-d') }}";
                $.get(url, function(data, status) {
                    if (status == "success") {
                        if (data.metadata.code == 200) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                            var pasien = data.response.peserta;
                            $("#nama").val(pasien.nama);
                            $("#nik").val(pasien.nik);
                            $("#nomorkartu").val(pasien.noKartu);
                            $("#tgllahir").val(pasien.tglLahir);
                            $("#gender").val(pasien.sex);
                            $("#jenispeserta").val(pasien.jenisPeserta.keterangan);
                            $("#fktp").val(pasien.provUmum.nmProvider);
                            $("#hakkelas").val(pasien.hakKelas.kode).change();
                            if (pasien.mr.noMR == null) {
                                Swal.fire(
                                    'Mohon Maaf !',
                                    "Pasien baru belum memiliki no RM",
                                    'error'
                                )
                            }
                            console.log(pasien);
                        } else {
                            // alert(data.metadata.message);
                            Swal.fire(
                                'Mohon Maaf !',
                                data.metadata.message,
                                'error'
                            )
                        }
                    } else {
                        console.log(data);
                        alert("Error Status: " + status);
                    }
                });
                $.LoadingOverlay("hide");
            });
            $('.btnCariNIK').click(function() {
                $.LoadingOverlay("show");
                var nik = $("#nik").val();
                var url = "{{ route('peserta_nik') }}?nik=" + nik +
                    "&tanggal={{ now()->format('Y-m-d') }}";
                $.get(url, function(data, status) {
                    if (status == "success") {
                        if (data.metadata.code == 200) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                            var pasien = data.response.peserta;
                            $("#nama").val(pasien.nama);
                            $("#nik").val(pasien.nik);
                            $("#nomorkartu").val(pasien.noKartu);
                            $("#tgllahir").val(pasien.tglLahir);
                            $("#gender").val(pasien.sex);
                            $("#jenispeserta").val(pasien.jenisPeserta.keterangan);
                            $("#fktp").val(pasien.provUmum.nmProvider);
                            $("#hakkelas").val(pasien.hakKelas.kode).change();
                            if (pasien.mr.noMR == null) {
                                Swal.fire(
                                    'Mohon Maaf !',
                                    "Pasien baru belum memiliki no RM",
                                    'error'
                                )
                            }
                            console.log(pasien);
                        } else {
                            // alert(data.metadata.message);
                            Swal.fire(
                                'Mohon Maaf !',
                                data.metadata.message,
                                'error'
                            )
                        }
                    } else {
                        console.log(data);
                        alert("Error Status: " + status);
                    }
                });
                $.LoadingOverlay("hide");
            });
            $("#tempat_lahir").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('get_kabupaten_name') }}",
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
        });
    </script>
@endsection
