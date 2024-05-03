<x-adminlte-modal id="modalPasien" name="modalPasien" title="Pasien" theme="success" icon="fas fa-user-injured"
    size="xl">
    <div class="row">
        <div class="col-md-7">
            <x-adminlte-button onclick="tambahPasien()" class="btn-sm mb-2" theme="success" label="Tambah Pasien"
                icon="fas fa-plus" />
        </div>
        <div class="col-md-5">
            <form action="" method="get">
                <x-adminlte-input name="searchPasien" onchange="btnCariPasien()"
                    placeholder="Pencarian No RM / BPJS / NIK / Nama" igroup-size="sm">
                    <x-slot name="appendSlot">
                        <x-adminlte-button onclick="btnCariPasien()" theme="primary" icon="fas fa-search"
                            label="Cari" />
                    </x-slot>
                </x-adminlte-input>
            </form>
        </div>
    </div>
    @php
        $heads = ['No RM', 'No BPJS', 'NIK', 'Nama Pasien', 'Tgl Lahir', 'Action'];
        $config['paging'] = false;
        $config['info'] = false;
        $config['searching'] = false;
    @endphp
    <x-adminlte-datatable id="tablePasien" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
        compressed>
    </x-adminlte-datatable>
</x-adminlte-modal>
<x-adminlte-modal id="tambahPasien" title="Tambah Pasien" size="xl" icon="fas fa-user-injured" theme="success">
    <form action="{{ route('pasien.store') }}" id="formPasien" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                    name="norm" label="No RM" placeholder="No RM" enable-old-support readonly />
                <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                    name="nik" label="NIK" placeholder="NIK" enable-old-support>
                    <x-slot name="appendSlot">
                        <div class="btn btn-primary" onclick="btnCariNIKPasien()">
                            <i class="fas fa-sync"></i> Sync
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                    name="nomorkartu" label="No BPJS" placeholder="no BPJS" enable-old-support>
                    <x-slot name="appendSlot">
                        <div class="btn btn-primary" onclick="btnCariKartuPasien()">
                            <i class="fas fa-sync"></i> Sync
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                    name="nama" label="Nama" placeholder="Nama" enable-old-support required />
                <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                    name="nohp" label="No HP" placeholder="No HP" enable-old-support />
                <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="gender" label="Jenis Kelamin">
                    <option selected disabled>Jenis Kelamin</option>
                    <option value="P">Perempuan</option>
                    <option value="L">Laki-Laki</option>
                </x-adminlte-select>
                <x-adminlte-select2 fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="tempat_lahir" label="Tempat Lahir">
                </x-adminlte-select2>
                @php
                    $config = ['format' => 'YYYY-MM-DD'];
                @endphp
                <x-adminlte-input-date fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="tgl_lahir" label="Tanggal Lahir" placeholder="Pilih Tanggal Lahir"
                    :config="$config">
                </x-adminlte-input-date>
            </div>
            <div class="col-md-6">
                <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="hakkelas" label="Hak Kelas">
                    <option selected disabled>Hak Kelas</option>
                    <option value="1">Kelas 1</option>
                    <option value="2">Kelas 2</option>
                    <option value="3">Kelas 3</option>
                </x-adminlte-select>
                <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="jenispeserta" label="Jenis Peserta" placeholder="Jenis Peserta"
                    enable-old-support />
                <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="fktp" label="FKTP" placeholder="Faskes Tingkat Pertama"
                    enable-old-support />
                <x-adminlte-textarea fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" rows=4 label="Alamat" name="alamat" placeholder="Alamat">
                </x-adminlte-textarea>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button form="formPasien" class="mr-auto" type="submit" icon="fas fa-user-plus" theme="success"
            label="Tambah Pasien Baru" />
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    <script>
        function modalPasien() {
            $('#modalPasien').modal('show');
        }

        function btnCariPasien() {
            $.LoadingOverlay("show");
            var search = $("#searchPasien").val();
            var url = "{{ route('pasiensearch') }}?search=" + search;
            console.log(url);
            var table = $('#tablePasien').DataTable();
            table.rows().remove().draw();
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    $.each(data.response, function(key, value) {
                        table.row.add([
                            value.norm,
                            value.nomorkartu,
                            value.nik,
                            value.nama,
                            value.tgl_lahir,
                            "<button class='btnPilihPasien btn btn-success btn-xs mr-1' data-norm=" +
                            value.norm +
                            " >Pilih</button>",
                        ]).draw(false);
                    });
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    console.log(data);
                    $.LoadingOverlay("hide");
                }
            });
        }

        function tambahPasien() {
            $('#tambahPasien').modal('show');
        }

        function btnCariKartuPasien() {
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

        }

        function btnCariNIKPasien() {
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
            $.LoadingOverlay("hide")
        }
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
@endpush
