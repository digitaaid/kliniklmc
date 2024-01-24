<form id="formSatuan">
    @csrf
    <style>
        .cariObat {
            width: 300px !important;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
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
