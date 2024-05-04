<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collAntrian">
        <h3 class="card-title">
            Antrian
        </h3>
        <div class="card-tools">
            <button type="button" onclick="modalAntrian()" class="btn btn-tool bg-warning">
                <i class="fas fa-edit"></i> Edit Antrian
            </button>
            @if ($antrian->norm)
                <button type="button" class="btn btn-tool bg-success">
                    <i class="fas fa-check"></i> Sudah Didaftarkan
                </button>
            @else
                <button type="button" class="btn btn-tool bg-danger">
                    <i class="fas fa-times"></i> Belum Didaftarkan
                </button>
            @endif
        </div>
    </a>
    <div id="collAntrian" class="collapse">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $antrian->nama }}</td>
                        </tr>
                        <tr>
                            <td>norm</td>
                            <td>:</td>
                            <td>{{ $antrian->norm }}</td>
                        </tr>
                        <tr>
                            <td>nomorkartu</td>
                            <td>:</td>
                            <td>{{ $antrian->nomorkartu }}</td>
                        </tr>
                        <tr>
                            <td>nik</td>
                            <td>:</td>
                            <td>{{ $antrian->nik }}</td>
                        </tr>

                        <tr>
                            <td>pasienbaru</td>
                            <td>:</td>
                            <td>{{ $antrian->pasienbaru }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <table>

                        <tr>
                            <td>Kodebooking</td>
                            <td>:</td>
                            <td>
                                <span class="badge badge-{{ $antrian->status ? 'success' : 'danger' }}">
                                    {{ $antrian->kodebooking }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Nomorantrean</td>
                            <td>:</td>
                            <td>{{ $antrian->nomorantrean }} / {{ $antrian->angkaantrean }}</td>
                        </tr>
                        <tr>
                            <td>jenispasien</td>
                            <td>:</td>
                            <td>{{ $antrian->jenispasien }}</td>
                        </tr>
                        <tr>
                            <td>jeniskunjungan</td>
                            <td>:</td>
                            <td>{{ $antrian->jeniskunjungan }}</td>
                        </tr>
                        <tr>
                            <td>nomorreferensi</td>
                            <td>:</td>
                            <td>{{ $antrian->nomorreferensi }}</td>
                        </tr>

                    </table>
                </div>
                <div class="col-md-4">
                    <table>
                        <tr>
                            <td>tanggalperiksa</td>
                            <td>:</td>
                            <td>{{ $antrian->tanggalperiksa }}</td>
                        </tr>
                        <tr>
                            <td>namapoli</td>
                            <td>:</td>
                            <td>{{ $antrian->namapoli }}</td>
                        </tr>
                        <tr>
                            <td>namadokter</td>
                            <td>:</td>
                            <td>{{ $antrian->namadokter }}</td>
                        </tr>
                        <tr>
                            <td>jampraktek</td>
                            <td>:</td>
                            <td>{{ $antrian->jampraktek }}</td>
                        </tr>
                        <tr>
                            <td>status</td>
                            <td>:</td>
                            <td>{{ $antrian->status }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<x-adminlte-modal id="modalAntrain" name="modalAntrain" icon="fas fa-user-injured" title="Antrian Pasien"
    theme="success" icon="fas fa-file-medical" size="xl">
    <form action="{{ route('editantrian') }}" id="formAntrian" method="POST">
        @csrf
        <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
        <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input name="nomorkartu" class="nomorkartu-antrian" fgroup-class="row"
                    label-class="text-left col-3" igroup-class="col-9" igroup-size="sm" label="Nomor Kartu"
                    value="{{ $antrian->nomorkartu }}" enable-old-support placeholder="Nomor Kartu">
                    <x-slot name="appendSlot">
                        <div class="btn btn-primary" onclick="btnCariKartu()">
                            <i class="fas fa-search"></i> Cari
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="nik" class="nik-id" enable-old-support fgroup-class="row"
                    label-class="text-left col-3" igroup-class="col-9" igroup-size="sm" label="NIK" placeholder="NIK"
                    value="{{ $antrian->nik }}">
                    <x-slot name="appendSlot">
                        <div class="btn btn-primary" onclick="btnCariNIK()">
                            <i class="fas fa-search"></i> Cari
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="norm" class="norm-id" label="No RM" fgroup-class="row"
                    label-class="text-left col-3" igroup-class="col-9" igroup-size="sm" placeholder="No RM"
                    value="{{ $antrian->norm }}" enable-old-support>
                    <x-slot name="appendSlot">
                        <div class="btn btn-primary" onclick="btnCariRM()">
                            <i class="fas fa-search"></i> Cari
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien" fgroup-class="row"
                    label-class="text-left col-3" igroup-class="col-9" igroup-size="sm" placeholder="Nama Pasien"
                    value="{{ $antrian->nama }}" enable-old-support />
                <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP" fgroup-class="row"
                    label-class="text-left col-3" igroup-class="col-9" igroup-size="sm" placeholder="Nomor HP"
                    value="{{ $antrian->nohp }}" enable-old-support />
            </div>
            <div class="col-md-6">
                @php
                    $config = ['format' => 'YYYY-MM-DD'];
                @endphp
                <x-adminlte-input-date name="tanggalperiksa" class="tanggalperiksa-id" fgroup-class="row"
                    label-class="text-left col-3" igroup-class="col-9" igroup-size="sm" label="Tanggal Periksa"
                    value="{{ $antrian->tanggalperiksa }}" placeholder="Tanggal Periksa" :config="$config"
                    enable-old-support>
                </x-adminlte-input-date>
                <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="jenispasien" label="Jenis Pasien" enable-old-support>
                    <option selected disabled>Pilih Jenis Pasien</option>
                    <option value="JKN" {{ $antrian->jenispasien == 'JKN' ? 'selected' : null }}>JKN
                    </option>
                    <option value="NON-JKN" {{ $antrian->jenispasien == 'NON-JKN' ? 'selected' : null }}>
                        NON-JKN
                    </option>
                </x-adminlte-select>
                <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="kodepoli" label="Poliklinik" enable-old-support>
                    @foreach ($polikliniks as $key => $value)
                        <option value="{{ $key }}">
                            {{ $value }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="kodedokter" label="Dokter" enable-old-support>
                    @foreach ($dokters as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </x-adminlte-select>
                @if ($antrian->jenispasien == 'JKN')
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" name="asalRujukan" class="asalRujukan-antrian" label="Jenis Rujukan"
                        enable-old-support>
                        <option value="1" {{ $antrian->jeniskunjungan == '1' ? 'selected' : null }}>
                            Rujukan
                            FKTP</option>
                        <option value="2" {{ $antrian->jeniskunjungan == '4' ? 'selected' : null }}>
                            Rujukan
                            Antar RS</option>
                    </x-adminlte-select>
                    <x-adminlte-input name="noRujukan" class="noRujukan-id" fgroup-class="row"
                        label-class="text-left col-3" igroup-class="col-9" igroup-size="sm" label="Nomor Rujukan"
                        placeholder="Nomor Rujukan" enable-old-support readonly value="{{ $antrian->nomorrujukan }}">
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" onclick="cariRujukanAntrian()">
                                <i class="fas fa-search"></i> Cari
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="noSurat" class="noSurat-id" fgroup-class="row"
                        label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                        label="Nomor Surat Kontrol" placeholder="Nomor Surat Kontrol"
                        value="{{ $antrian->nomorsuratkontrol }}" enable-old-support readonly>
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" onclick="cariSuratKontrol()">
                                <i class="fas fa-search"></i> Cari
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                @endif
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="success" icon="fas fa-edit" class="mr-auto withLoad" label="Simpan"
            type="submit" form="formAntrian" />
        <x-adminlte-button theme="warning" icon="fas fa-users" onclick="modalPasien()" label="Data Pasien" />
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    <script>
        function modalAntrian() {
            $('#modalAntrain').modal('show');
        }

        function cariRujukanAntrian() {
            $.LoadingOverlay("show");
            var asalRujukan = $(".asalRujukan-antrian").find(":selected").val();
            var nomorkartu = $(".nomorkartu-antrian").val();
            $('#modalRujukan').modal('show');
            var table = $('#tableRujukan').DataTable();
            table.rows().remove().draw();
            var url = "{{ route('rujukan_peserta') }}?nomorkartu=" + nomorkartu;
            switch (asalRujukan) {
                case '1':
                    var url = "{{ route('rujukan_peserta') }}?nomorkartu=" + nomorkartu;
                    break;
                case '2':
                    var url = "{{ route('rujukan_rs_peserta') }}?nomorkartu=" + nomorkartu;
                    break;
                default:
                    Swal.fire(
                        'Error',
                        'Pilih Jenis Rujukan',
                        'error'
                    );
                    break;
            }
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $.each(data.response.rujukan, function(key, value) {
                            table.row.add([
                                value.tglKunjungan,
                                value.noKunjungan,
                                value.provPerujuk.nama,
                                value.peserta.nama,
                                value.pelayanan.nama,
                                value.poliRujukan.nama,
                                "<button class='btnPilihRujukan btn btn-success btn-xs' data-id=" +
                                value.noKunjungan +
                                " data-kelas=" + value.peserta.hakKelas
                                .kode +
                                " data-tglrujukan=" + value.tglKunjungan +
                                " data-ppkrujukan=" + value.provPerujuk
                                .kode +
                                " >Pilih</button>",
                            ]).draw(false);
                        });
                        $('.btnPilihRujukan').click(function() {
                            $.LoadingOverlay("show");
                            $('#ppkrujukan').val($(this).data('ppkrujukan'));
                            $('.noRujukan-id').val($(this).data('id'));
                            $('#klsRawatHak').val($(this).data('kelas')).change();
                            $('#tglrujukan').val($(this).data('tglrujukan'));
                            $('#modalRujukan').modal('hide');
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
        }

        function btnCariKartu() {
            $.LoadingOverlay("show");
            var nomorkartu = $(".nomorkartu-antrian").val();
            var url = "{{ route('cari_pasien_nomorkartu') }}?nomorkartu=" + nomorkartu +
                "&tanggal={{ now()->format('Y-m-d') }}";
            $.get(url, function(data, status) {
                if (status == "success") {
                    if (data.metadata.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Pasien Ditemukan'
                        });
                        var pasien = data.response;
                        $(".nama-id").val(pasien.nama);
                        $(".nik-id").val(pasien.nik);
                        $(".nomorkartu-antrian").val(pasien.nomorkartu);
                        $(".norm-id").val(pasien.norm);
                        $(".tgllahir-id").val(pasien.tgllahir);
                        $(".gender-id").val(pasien.gender);
                        $(".penjamin-id").val(pasien.penjamin);
                        $(".kelas-id").val(pasien.kelas);
                        $(".nohp-id").val(pasien.nohp);
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

        function btnCariNIK() {
            $.LoadingOverlay("show");
            var nomorkartu = $(".nik-id").val();
            var url = "{{ route('cari_pasien_nik') }}?nik=" + nomorkartu +
                "&tanggal={{ now()->format('Y-m-d') }}";
            $.get(url, function(data, status) {
                if (status == "success") {
                    if (data.metadata.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Pasien Ditemukan'
                        });
                        var pasien = data.response;
                        $(".nama-id").val(pasien.nama);
                        $(".nik-id").val(pasien.nik);
                        $(".nomorkartu-antrian").val(pasien.nomorkartu);
                        $(".norm-id").val(pasien.norm);
                        $(".tgllahir-id").val(pasien.tgllahir);
                        $(".gender-id").val(pasien.gender);
                        $(".penjamin-id").val(pasien.penjamin);
                        $(".kelas-id").val(pasien.kelas);
                        $(".nohp-id").val(pasien.nohp);
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

        function btnCariRM() {
            $.LoadingOverlay("show");
            var norm = $(".norm-id").val();
            var url = "{{ route('cari_pasien_norm') }}?norm=" + norm +
                "&tanggal={{ now()->format('Y-m-d') }}";
            $.get(url, function(data, status) {
                if (status == "success") {
                    if (data.metadata.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Pasien Ditemukan'
                        });
                        var pasien = data.response;
                        $(".nama-id").val(pasien.nama);
                        $(".nik-id").val(pasien.nik);
                        $(".nomorkartu-antrian").val(pasien.nomorkartu);
                        $(".norm-id").val(pasien.norm);
                        $(".tgllahir-id").val(pasien.tgllahir);
                        $(".gender-id").val(pasien.gender);
                        $(".penjamin-id").val(pasien.penjamin);
                        $(".kelas-id").val(pasien.kelas);
                        $(".nohp-id").val(pasien.nohp);
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
    </script>
@endpush
