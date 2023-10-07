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
                        <x-adminlte-button id="btnTambah" class="btn-sm mb-2" theme="success" label="Tambah Pasien"
                            icon="fas fa-plus" />
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
                    $heads = ['No', 'No RM', 'No BPJS', 'NIK', 'Nama Pasien', 'Gender', 'Tgl Lahir', 'Action', 'PIC'];
                    $config['order'] = [1, 'desc'];
                    $config['paging'] = false;
                    $config['lengthMenu'] = false;
                    $config['searching'] = false;
                    $config['info'] = false;
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($pasiens as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->norm }}</td>
                            <td>{{ $item->nomorkartu }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ $item->tgl_lahir }} ({{ Carbon\Carbon::parse($item->tgl_lahir)->age }} tahun) </td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" label="Edit" icon="fas fa-edit"
                                    title="Edit Pasien {{ $item->nama }}" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}" data-nohp="{{ $item->nohp }}"
                                    data-gender="{{ $item->gender }}" data-tempat_lahir="{{ $item->tempat_lahir }}"
                                    data-tgl_lahir="{{ $item->tgl_lahir }}" data-nik="{{ $item->nik }}"
                                    data-nomorkartu="{{ $item->nomorkartu }}" data-norm="{{ $item->norm }}"
                                    data-alamat="{{ $item->alamat }}" />
                            </td>
                            <td>
                                {{ $item->pic ? $item->pic->name : $item->user }}

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
                    <x-adminlte-input name="nama" label="Nama Lengkap" placeholder="Nama Lengkap" enable-old-support
                        required />
                    <x-adminlte-input name="norm" label="No RM" placeholder="No RM" enable-old-support />
                    <x-adminlte-input name="nik" label="NIK" placeholder="NIK" enable-old-support />
                    <x-adminlte-input name="nomorkartu" label="No BPJS" placeholder="no BPJS" enable-old-support />
                    <x-adminlte-input name="nohp" label="No HP" placeholder="No HP" enable-old-support />
                </div>
                <div class="col-md-6">
                    <x-adminlte-select2 name="gender" label="Jenis Kelamin">
                        <option selected disabled>Jenis Kelamin</option>
                        <option value="P">Perempuan</option>
                        <option value="L">Laki-Laki</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="tempat_lahir" label="Tempat Lahir">
                    </x-adminlte-select2>
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tgl_lahir" label="Tanggal Lahir" placeholder="Pilih Tanggal Lahir"
                        :config="$config">
                    </x-adminlte-input-date>
                    <x-adminlte-textarea igroup-size="sm" rows=4 label="Alamat" name="alamat" placeholder="Alamat">
                    </x-adminlte-textarea>
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
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
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
                $('#gender').val($(this).data("gender")).change();

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
