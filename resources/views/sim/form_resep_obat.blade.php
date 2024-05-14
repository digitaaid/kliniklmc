<form id="formEditResep" action={{ route('update_resep_obat') }} method="POST">
    @csrf
    <style>
        .cariObat {
            width: 300px !important;
        }
    </style>
    <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
    <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
    <input type="hidden" name="kodekunjungan" value="{{ $kunjungan->kode ?? null }}">
    <input type="hidden" name="kunjungan_id" value="{{ $kunjungan->id ?? null }}">
    <button type="button" class="btn btn-sm btn-success" onclick="modalPasien()">
        <i class="fas fa-users "></i> Data Pasien</button>
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
            <x-adminlte-input name="tgl_lahir" class="tgllahir-id" enable-old-support label="Tanggal Lahir"
                fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                value="{{ $antrian->kunjungan->tgl_lahir ?? null }}" igroup-size="sm" placeholder="Tanggal Lahir" />
            <x-adminlte-input name="gender" class="gender-id" enable-old-support label="Jenis Kelamin"
                fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                value="{{ $antrian->kunjungan->gender ?? null }}" igroup-size="sm" placeholder="Jenis Kelamin" />
            <x-adminlte-input name="kelas" enable-old-support value="{{ $antrian->kunjungan->kelas ?? null }}"
                class="kelas-id" label="Kelas Pasien" fgroup-class="row" label-class="text-left col-3"
                igroup-class="col-9" igroup-size="sm" placeholder="Kelas Pasien" />
            <x-adminlte-input name="penjamin" class="penjamin-id" enable-old-support label="Penjamin"
                fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                placeholder="Penjamin" value="{{ $antrian->kunjungan->penjamin ?? null }}" />
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
                    <option value="{{ $key }}" {{ $antrian->kodepoli == $key ? 'selected' : null }}>
                        {{ $value }}</option>
                @endforeach
            </x-adminlte-select>
            <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                igroup-size="sm" name="kodedokter" label="Dokter" enable-old-support>
                @foreach ($dokters as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </x-adminlte-select>
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <x-adminlte-input-date fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                name="tgl_masuk" igroup-size="sm" label="Tanggal Masuk" enable-old-support
                placeholder="Tanggal Masuk" :config="$config" value="{{ $antrian->kunjungan->tgl_masuk ?? now() }}">
            </x-adminlte-input-date>
            <x-adminlte-select igroup-size="sm" fgroup-class="row" label-class="text-left col-3"
                igroup-class="col-9" name="jaminan" label="Jaminan Pasien" enable-old-support>
                <option selected disabled>Pilih Jaminan</option>
                @foreach ($jaminans as $key => $item)
                    <option value="{{ $key }}"
                        {{ $antrian->kunjungan ? ($antrian->kunjungan->jaminan == $key ? 'selected' : null) : null }}>
                        {{ $item }}
                    </option>
                @endforeach
            </x-adminlte-select>
            <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                igroup-size="sm" name="cara_masuk" label="Cara Masuk" enable-old-support>
                <option selected disabled>Pilih Cara Masuk</option>
                <option value="gp"
                    {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'gp' ? 'selected' : null) : null }}>
                    Rujukan
                    FKTP</option>
                <option value="hosp-trans"
                    {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'hosp-trans' ? 'selected' : null) : null }}>
                    Rujukan FKRTL</option>
                <option value="mp"
                    {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'mp' ? 'selected' : null) : null }}>
                    Rujukan
                    Spesialis</option>
                <option value="outp"
                    {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'outp' ? 'selected' : null) : null }}>
                    Dari
                    Rawat Jalan</option>
                <option value="inp"
                    {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'inp' ? 'selected' : null) : null }}>
                    Dari
                    Rawat Inap</option>
                <option value="emd"
                    {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'emd' ? 'selected' : null) : null }}>
                    Dari
                    Rawat Darurat</option>
                <option value="born"
                    {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'born' ? 'selected' : null) : null }}>
                    Lahir
                    di RS</option>
                <option value="nursing"
                    {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'nursing' ? 'selected' : null) : null }}>
                    Rujukan Panti Jompo</option>
                <option value="psych"
                    {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'psych' ? 'selected' : null) : null }}>
                    Rujukan dari RS Jiwa</option>
                <option value="rehab"
                    {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'rehab' ? 'selected' : null) : null }}>
                    Rujukan Fasilitas Rehab</option>
                <option value="other"
                    {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'other' ? 'selected' : null) : null }}>
                    Lain-lain</option>
            </x-adminlte-select>
            <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                igroup-size="sm" name="diagnosa_awal" enable-old-support class="diagnosaid2" label="Diagnosa Awal">
                @if ($antrian->kunjungan)
                    <option value="{{ $antrian->kunjungan->diagnosa_awal }}">
                        {{ $antrian->kunjungan->diagnosa_awal }}
                    </option>
                @endif
            </x-adminlte-select>
            <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                igroup-size="sm" name="jeniskunjungan" enable-old-support label="Jenis Kunjungan">
                <option selected disabled>Pilih Jenis Rujukan</option>
                <option value="1" {{ $antrian->jeniskunjungan == '1' ? 'selected' : null }}>
                    Rujukan FKTP</option>
                <option value="2" {{ $antrian->jeniskunjungan == '2' ? 'selected' : null }}>
                    Umum</option>
                <option value="3" {{ $antrian->jeniskunjungan == '3' ? 'selected' : null }}>
                    Kontrol</option>
                <option value="4" {{ $antrian->jeniskunjungan == '4' ? 'selected' : null }}>
                    Rujukan Antar RS</option>
            </x-adminlte-select>
        </div>
        <div class="col-md-12">
            <hr>
            <label class="mb-2">Resep Obat</label>
            <button id="addObatInput" type="button" class="btn btn-xs btn-success mb-2">
                <span class="fas fa-plus">
                </span> Tambah Obat
            </button>
            @if ($antrian->resepobat)
                @foreach ($antrian->resepobat->resepdetail as $itemobat)
                    <div id="row" class="row">
                        <div class="form-group">
                            <div class="input-group input-group-sm">
                                <select name="obat[]" class="form-control cariObat">
                                    <option value="{{ $itemobat->obat_id }}">
                                        {{ $itemobat->nama }}</option>
                                </select>
                                <input type="number" name="jumlah[]" value="{{ $itemobat->jumlah }}"
                                    placeholder="Jumlah" class="form-control" multiple>
                                <select name="frekuensi[]"class="form-control frekuensilObat">
                                    <option selected disabled>Interval</option>
                                    <option value="qod" {{ $itemobat->interval == 'qod' ? 'selected' : null }}>
                                        1 x 1</option>
                                    <option value="dod" {{ $itemobat->interval == 'dod' ? 'selected' : null }}>
                                        1 x 2</option>
                                    <option value="bid" {{ $itemobat->interval == 'bid' ? 'selected' : null }}>
                                        2 x 1</option>
                                    <option value="tid" {{ $itemobat->interval == 'tid' ? 'selected' : null }}>
                                        3 x 1</option>
                                    <option value="qid" {{ $itemobat->interval == 'qid' ? 'selected' : null }}>
                                        4 x 1</option>
                                    <option value="202" {{ $itemobat->interval == '202' ? 'selected' : null }}>
                                        2-0-2</option>
                                    <option value="303" {{ $itemobat->interval == '303' ? 'selected' : null }}>
                                        3-0-3</option>
                                </select>
                                <select name="waktuobat[]" class="form-control waktuObat">
                                    <option selected>Waktu Obat</option>
                                    <option value="pc" {{ $itemobat->waktu == 'pc' ? 'selected' : null }}>
                                        Setelah Makan</option>
                                    <option value="ac" {{ $itemobat->waktu == 'ac' ? 'selected' : null }}>
                                        Sebelum Makan</option>
                                    <option value="hs" {{ $itemobat->waktu == 'hs' ? 'selected' : null }}>
                                        Sebelum Tidur</option>
                                    <option value="int" {{ $itemobat->waktu == 'int' ? 'selected' : null }}>
                                        Diantara Waktu Makan</option>
                                </select>
                                <input type="text" name="keterangan_obat[]" value="{{ $itemobat->keterangan }}"
                                    placeholder="Keterangan Obat" class="form-control" multiple>
                                <button type="button" class="btn btn-xs btn-danger" id="deleteRowObat"><i
                                        class="fas fa-trash "></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            <div id="rowTindakan" class="row">
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <select name="obat[]" class="form-control cariObat">
                        </select>
                        <input type="number" name="jumlah[]" placeholder="Jumlah" class="form-control" multiple>
                        <select name="frekuensi[]" class="form-control frekuensilObat">
                            <option selected disabled>Interval</option>
                            <option value="qod">1 x 1</option>
                            <option value="dod">1 x 2</option>
                            <option value="bid">2 x 1</option>
                            <option value="tid">3 x 1</option>
                            <option value="qid">4 x 1</option>
                            <option value="202">2-0-2</option>
                            <option value="303">3-0-3</option>
                        </select>
                        <select name="waktuobat[]" class="form-control waktuObat">
                            <option selected>Waktu Obat</option>
                            <option value="pc">Setelah Makan</option>
                            <option value="ac">Sebelum Makan</option>
                            <option value="hs">Sebelum Tidur</option>
                            <option value="int">Diantara Waktu Makan</option>
                        </select>
                        <input type="text" name="keterangan_obat[]" placeholder="Keterangan Obat"
                            class="form-control" multiple>
                        <button type="button" class="btn btn-xs btn-warning">
                            <i class="fas fa-pills "></i>
                        </button>
                    </div>
                </div>
            </div>
            <div id="newObat"></div>
        </div>
        <div class="col-md-6">
            <x-adminlte-textarea igroup-size="sm" rows=3 label="Resep Obat (Free Text)" name="resep_obat"
                placeholder="Resep Obat (Text)">
                {{ $kunjungan->asesmendokter->resep_obat ?? null }}
            </x-adminlte-textarea>
        </div>
        <div class="col-md-6">
            <x-adminlte-textarea igroup-size="sm" rows=3 label="Catatan Resep" name="catatan_resep"
                placeholder="Catatan Resep">
                {{ $kunjungan->asesmendokter->catatan_resep ?? null }}
            </x-adminlte-textarea>
        </div>
    </div>
</form>
{{-- dynamic input --}}
<script>
    $("#addObatInput").click(function() {
        newRowAdd =
            '<div id="row" class="row"><div class="form-group"><div class="input-group input-group-sm">' +
            '<select name="obat[]" class="form-control cariObat"></select>' +
            '<input type="number" name="jumlah[]" placeholder="Jumlah" class="form-control" multiple>' +
            '<select name="frekuensi[]"class="form-control frekuensilObat"> <option selected disabled>Interval</option>' +
            '<option value="qod">1 x 1</option>' +
            '<option value="dod">1 x 2</option>' +
            '<option value="bid">2 x 1</option>' +
            '<option value="tid">3 x 1</option>' +
            '<option value="qid">4 x 1</option>' +
            '<option value="202">2-0-2</option>' +
            '<option value="303">3-0-3</option>' +
            '</select> ' +
            '<select name="waktuobat[]" class="form-control waktuObat"><option selected>Waktu Obat</option>' +
            '<option value="pc">Setelah Makan</option>' +
            '<option value="ac">Sebelum Makan</option>' +
            '<option value="hs">Sebelum Tidur</option>' +
            '<option value="int">Diantara Waktu Makan</option>' +
            '</select> ' +
            '<input type="text" name="keterangan_obat[]" placeholder="Keterangan Obat" class="form-control" multiple>' +
            '<button type="button" class="btn btn-xs btn-danger" id="deleteRowObat"><i class="fas fa-trash "></i> </div></div></div>';
        $('#newObat').append(newRowAdd);
        $(".cariObat").select2({
            placeholder: 'Pencarian Nama Obat',
            theme: "bootstrap4",
            multiple: true,
            maximumSelectionLength: 1,
            ajax: {
                url: "{{ route('ref_obat_cari') }}",
                type: "get",
                dataType: 'json',
                delay: 100,
                data: function(params) {
                    return {
                        nama: params.term // search term
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
    $("body").on("click", "#deleteRowObat", function() {
        $(this).parents("#row").remove();
    })
</script>
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
    });
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
