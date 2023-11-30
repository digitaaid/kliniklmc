@extends('adminlte::page')

@section('title', 'File Upload')

@section('content_header')
    <h1>File Upload</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Data File Upload" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['Id', 'Tgl Upload', 'No RM', 'Pasien', 'Nama File', 'Kode Booking', 'Kode Kunjungan', 'Label', 'Action'];
                    $config['paging'] = false;
                    $config['scrollY'] = '500px';
                @endphp
                <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($fileuploads as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->norm }}</td>
                            <td>{{ $item->namapasien }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kodebooking }}</td>
                            <td>{{ $item->kodekunjungan }}</td>
                            <td>{{ $item->label }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" label="Edit" icon="fas fa-edit"
                                    title="Edit File {{ $item->nama }}" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}" data-namapasien="{{ $item->namapasien }}"
                                    data-norm="{{ $item->norm }}" data-label="{{ $item->label }}"
                                    data-fileurl="{{ $item->fileurl }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalEdit" title="File Upload" size="xl" theme="warning" icon="fas fa-user-plus">
        <form name="formFile" id="formFile" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <div class="row">
                <div class="col-md-5">
                    <x-adminlte-input name="nama" placeholder="Nama File" label="Nama File" />
                    <x-adminlte-input name="norm" placeholder="No RM" label="No RM" />
                    <x-adminlte-input name="namapasien" placeholder="Nama Pasien" label="Nama Pasien" />
                    <x-adminlte-select name="label" label="Label">
                        <option selected disabled>Pilih Label File</option>
                        <option value="Lain-lain">Lain-lain</option>
                        <option value="Laboratorium">Laboratorium</option>
                        <option value="Radiologi">Radiologi</option>
                        <option value="Patologi Anatomi">Patologi Anatomi</option>
                        <option value="Imunohistokimia">Imunohistokimia</option>
                        <option value="Rawat Jalan">Rawat Jalan</option>
                        <option value="Rawat Inap">Rawat Inap</option>
                        <option value="Kemoterapi">Kemoterapi</option>
                        <option value="USG">USG</option>
                        <option value="Echocardiography">Echocardiography</option>
                        <option value="Rekam Medis">Rekam Medis</option>
                    </x-adminlte-select>
                    <x-adminlte-input-file name="file" placeholder="Pilih file yang akan diupload" igroup-size="sm"
                        label="Upload File (.pdf)" />
                </div>
                <div class="col-md-7">
                    <iframe id="dataFilePenunjang" src="" height="600px" width="100%"
                        title="Iframe Example"></iframe>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button id="btnStore" class="" type="submit" icon="fas fa-save" theme="success"
                    label="Simpan" />
                <x-adminlte-button id="btnUpdate" class="" type="submit" icon="fas fa-edit" theme="warning"
                    label="Update" />
                <a href="" id="urlFilePenunjang" target="_blank" class="btn btn-primary mr-auto">
                    <i class="fas fa-download "></i>Download</a>
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
            </x-slot>
        </form>
        <form id="formDelete" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </x-adminlte-modal>
    {{-- <x-adminlte-modal id="modalUser" title="User" icon="fas fa-user" theme="success" v-centered static-backdrop>
        <form action="" id="formUser" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="name" label="Nama" placeholder="Nama Lengkap" enable-old-support required />
            <x-adminlte-select2 id="role" name="role" label="Role / Jabatan" enable-old-support required>
                <option value="" selected disabled>Pilih Role / Jabatan</option>
                @foreach ($roles as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </x-adminlte-select2>
            <x-adminlte-input name="phone" type="number" label="Nomor HP / Telepon"
                placeholder="Nomor HP / Telepon yang dapat dihubungi" enable-old-support />
            <x-adminlte-input name="email" type="email" label="Email" placeholder="Email" enable-old-support
                required />
            <x-adminlte-input name="username" label="Username" placeholder="Username" enable-old-support required />
            <x-adminlte-input name="password" type="password" label="Password" placeholder="Password" required />
            <x-adminlte-input name="password_confirmation" type="password" label="Konfirmasi Password"
                placeholder="Konfirmasi Password" required />
        </form>

        <x-slot name="footerSlot">
            <x-adminlte-button id="btnStore" class="mr-auto" type="submit" icon="fas fa-save" theme="success"
                label="Simpan" />
            <x-adminlte-button id="btnUpdate" class="mr-auto" type="submit" icon="fas fa-edit" theme="warning"
                label="Update" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal> --}}
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.BsCustomFileInput', true)

@section('js')
    <script>
        $(function() {
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formFile').trigger("reset");
                var id = $(this).data("id");
                $('#id').val(id);
                $('#nama').val($(this).data("nama"));
                $('#norm').val($(this).data("norm"));
                $('#namapasien').val($(this).data("namapasien"));
                $('#label').val($(this).data("label"));
                $('#fileurl').val($(this).data("fileurl"));
                $('#dataFilePenunjang').attr('src', $(this).data('fileurl'));
                $('#urlFilePenunjang').attr('href', $(this).data('fileurl'));
                $('#modalEdit').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('fileupload.index') }}/" + id;
                $('#formFile').attr('action', url);
                $('#method').val('PUT');
                $('#formFile').submit();
            });
            $('.btnDelete').click(function(e) {
                e.preventDefault();
                var name = $(this).data("name");
                swal.fire({
                    title: 'Apakah anda ingin menonaktifkan dokter ' + name + ' ?',
                    showConfirmButton: false,
                    showDenyButton: true,
                    showCancelButton: true,
                    denyButtonText: `Ya, Non Aktifkan`,
                }).then((result) => {
                    if (result.isDenied) {
                        $.LoadingOverlay("show");
                        var id = $(this).data("id");
                        var url = "{{ route('fileupload.index') }}/" + id;
                        $('#formDelete').attr('action', url);
                        $('#formDelete').submit();
                    }
                })
            });
        });
    </script>
@endsection
