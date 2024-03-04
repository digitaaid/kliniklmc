<x-adminlte-modal id="modalAsesmenDokter" title="Asesmen Dokter" size="xl" icon="fas fa-hand-holding-medical"
    theme="success">
    <form action="{{ route('editasesmendokter') }}" name="formAsesmenDokter" id="formAsesmenDokter" method="POST">
        @csrf
        <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
        <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
        <input type="hidden" name="kodekunjungan" value="{{ $antrian->kunjungan->kode ?? null }}">
        <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id ?? null }}">
        <h6>Subjective (S) - Keluhan Utama, Nyeri & Resiko Jatuh</h6>
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-select name="sumber_data" label="Sumber Data" fgroup-class="row"
                    label-class="text-left col-3" igroup-size="sm" igroup-class="col-9">
                    <option
                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->sumber_data == 'Pasien Sendiri / Autoanamase' ? 'selected' : null) : null }}>
                        Pasien
                        Sendiri / Autoanamase</option>
                    <option
                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->sumber_data == 'Keluarga / Alloanamnesa' ? 'selected' : null) : null }}>
                        Keluarga / Alloanamnesa</option>
                </x-adminlte-select>
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Keluhan Utama" name="keluhan_utama"
                    placeholder="Keluhan Utama">
                    {{ $antrian->asesmenperawat->keluhan_utama ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan"
                    name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">
                    {{ $antrian->asesmenperawat->riwayat_pengobatan ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Penyakit"
                            name="riwayat_penyakit" placeholder="Riwayat Penyakit">
                            {{ $antrian->asesmenperawat->riwayat_penyakit ?? null }}
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Penyakit Keluarga"
                            name="riwayat_penyakit_keluarga" placeholder="Riwayat Penyakit">
                            {{ $antrian->asesmenperawat->riwayat_penyakit_keluarga ?? null }}
                        </x-adminlte-textarea>
                    </div>
                </div>
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Alergi" name="riwayat_alergi"
                    placeholder="Riwayat Alergi">
                    {{ $antrian->asesmenperawat->riwayat_alergi ?? null }}
                </x-adminlte-textarea>

            </div>
        </div>
        <h6>Objective (O) - Tanda Vital & Pemeriksaan Fisik</h6>
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input name="denyut_jantung" label="Denyut Jantung" igroup-size="sm" type="number"
                    placeholder="Denyut Jantung" fgroup-class="row" label-class="text-left col-5" igroup-size="sm"
                    igroup-class="col-7" value="{{ $antrian->asesmenperawat->denyut_jantung ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            bpm
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="pernapasan" label="Pernapasan" igroup-size="sm"
                    placeholder="Pernapasan" fgroup-class="row" label-class="text-left col-5" igroup-size="sm"
                    igroup-class="col-7" type="number" value="{{ $antrian->asesmenperawat->pernapasan ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            spm
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="sistole" label="Sistole" igroup-size="sm" placeholder="Sistole"
                    fgroup-class="row" label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                    type="number" value="{{ $antrian->asesmenperawat->sistole ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            mmHg
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="distole" label="Diastole" igroup-size="sm" placeholder="Diastole"
                    fgroup-class="row" label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                    type="number" value="{{ $antrian->asesmenperawat->distole ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            mmHg
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="suhu" label="Suhu Tubuh" igroup-size="sm" fgroup-class="row"
                    label-class="text-left col-5" igroup-size="sm" igroup-class="col-7" placeholder="Suhu Tubuh"
                    value="{{ $antrian->asesmenperawat->suhu ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            celcius
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="berat_badan" label="Berat Badan" igroup-size="sm"
                    fgroup-class="row" label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                    placeholder="Berat Badan" type="number"
                    value="{{ $antrian->asesmenperawat->berat_badan ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            kg
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="tinggi_badan" type="number" label="Tinggi Badan"
                    fgroup-class="row" label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                    igroup-size="sm" placeholder="Tinggi Badan"
                    value="{{ $antrian->asesmenperawat->tinggi_badan ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            cm
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="bsa" type="number" label="Index BSA (m2)" fgroup-class="row"
                    label-class="text-left col-5" igroup-size="sm" igroup-class="col-7" igroup-size="sm"
                    placeholder="Index BSA (m2)" value="{{ $antrian->asesmenperawat->bsa ?? null }}" disabled>
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            kg/m2
                        </div>
                    </x-slot>
                </x-adminlte-input>

            </div>
        </div>
        <x-adminlte-select name="tingkat_kesadaran" label="Tingkat Kesadaran">
            <option value="1"
                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == '1' ? 'selected' : null) : null }}>
                Sadar
                Baik/Alert
            </option>
            <option value="2"
                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == '2' ? 'selected' : null) : null }}>
                Berespon
                dengan kata-kata/Voice
            </option>
            <option value="3"
                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == '3' ? 'selected' : null) : null }}>
                Hanya
                berespons jika dirangsang nyeri/pain
            </option>
            <option value="4"
                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == '4' ? 'selected' : null) : null }}>
                Pasien tidak
                sadar/unresponsive
            </option>
            <option value="5"
                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == '5' ? 'selected' : null) : null }}>
                Gelisah atau
                bingung
            </option>
            <option value="6"
                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == '6' ? 'selected' : null) : null }}>
                Acute
                Confusional States
            </option>
        </x-adminlte-select>
        <x-adminlte-textarea igroup-size="sm" rows=4 label="Tanda Vital Tubuh" name="keadaan_tubuh"
            placeholder="Tanda Vital Tubuh">
            {{ $antrian->asesmenperawat->keadaan_tubuh ?? null }}
        </x-adminlte-textarea>
        <x-adminlte-textarea igroup-size="sm" rows=4 label="Pemeriksaan Fisik" name="pemeriksaan_fisik"
            placeholder="Pemeriksaan Fisik">
            {{ $antrian->asesmendokter->pemeriksaan_fisik ?? null }}
        </x-adminlte-textarea>
        {{-- <h6>Objective (O) - Laboratorium, Radiologi, & Penunjang Lainnya</h6>
        <div class="row">
            <div class="col-md-4">
                <x-adminlte-textarea igroup-size="sm" rows=4 label="Hasil Pemeriksaan Laboratorium"
                    name="pemeriksaan_lab" placeholder="Hasil Pemeriksaan Laboratorium">
                    {{ $antrian->asesmenperawat->pemeriksaan_lab ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-4">
                <x-adminlte-textarea igroup-size="sm" rows=4 label="Hasil Pemeriksaan Radiologi"
                    name="pemeriksaan_rad" placeholder="Hasil Pemeriksaan Radiologi">
                    {{ $antrian->asesmenperawat->pemeriksaan_rad ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-4">
                <x-adminlte-textarea igroup-size="sm" rows=4 label="Hasil Pemeriksaan Penunjang Lainnya"
                    name="pemeriksaan_penunjang" placeholder="Hasil Pemeriksaan Penunjang Lainnya">
                    {{ $antrian->asesmenperawat->pemeriksaan_penunjang ?? null }}
                </x-adminlte-textarea>
            </div>
        </div> --}}
        <h6>Analysis (A)</h6>
        <x-adminlte-textarea igroup-size="sm" rows=3 label="Diagnosa Keperawatan"
            name="diagnosa_keperawatan" placeholder="Diagnosa Masuk">
            {{ $antrian->asesmenperawat->diagnosa_keperawatan ?? null }}
        </x-adminlte-textarea>
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-select2 name="diagnosa[]" class="diagnosa" label="Diagnosa :" multiple>
                    @if ($antrian->asesmendokter)
                        @if (is_array(json_decode($antrian->asesmendokter->diagnosa)) ||
                                is_object(json_decode($antrian->asesmendokter->diagnosa)))
                            @foreach (json_decode($antrian->asesmendokter->diagnosa) as $item)
                                <option value="{{ $item }}" selected>
                                    {{ $item }}
                                </option>
                            @endforeach
                        @else
                            <option value="{{ $antrian->asesmendokter->diagnosa }}" selected>
                                {{ $antrian->asesmendokter->diagnosa }}
                            </option>
                        @endif
                    @endif
                </x-adminlte-select2>
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Diagnosa Sekunder"
                    name="catatan_diagnosa" placeholder="Diagnosa Sekunder (Free Text)">
                    {{ $kunjungan->asesmendokter->catatan_diagnosa ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-select2 name="diagnosa1" class="diagnosaid1" label="Diagnosa Primer ICD-10 : ">
                    @if ($antrian->asesmendokter)
                        <option value="{{ $antrian->asesmendokter->diagnosa1 }}" selected>
                            {{ $antrian->asesmendokter->diagnosa1 }}
                        </option>
                    @endif
                </x-adminlte-select2>
                <x-adminlte-select2 name="diagnosa2[]" class="diagnosaid2" label="Diagnosa Sekunder ICD-10 : "
                    multiple>
                    @if ($antrian->asesmendokter)
                        @if (is_array(json_decode($antrian->asesmendokter->diagnosa2)) ||
                                is_object(json_decode($antrian->asesmendokter->diagnosa2)))
                            @foreach (json_decode($antrian->asesmendokter->diagnosa2) as $item)
                                <option value="{{ $item }}" selected>
                                    {{ $item }}
                                </option>
                            @endforeach
                        @else
                            <option value="{{ $antrian->asesmendokter->diagnosa2 }}" selected>
                                {{ $antrian->asesmendokter->diagnosa2 }}
                            </option>
                        @endif
                    @endif
                </x-adminlte-select2>
            </div>
        </div>
        <h6>Planning (P)</h6>
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Rencana Keperawatan"
                    name="rencana_keperawatan" placeholder="Rencana Keperawatan">
                    {{ $antrian->asesmenperawat->rencana_keperawatan ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Tindakan Keperawatan"
                    name="tindakan_keperawatan" placeholder="Tindakan Keperawatan">
                    {{ $antrian->asesmenperawat->tindakan_keperawatan ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Evaluasi Keperawatan"
                    name="evaluasi_keperawatan" placeholder="Evaluasi Keperawatan">
                    {{ $antrian->asesmenperawat->evaluasi_keperawatan ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Instruksi Dokter" name="instruksi_medis"
                    placeholder="Instruksi Medis">
                    {{ $kunjungan->asesmendokter->instruksi_medis ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Tindakan Dokter" name="tindakan_medis"
                    placeholder="Tindakan Medis">
                    {{ $kunjungan->asesmendokter->tindakan_medis ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Catatan Dokter" name="rencana_perawatan"
                    placeholder="Rencana Perawatan">
                    {{ $kunjungan->asesmendokter->rencana_perawatan ?? null }}
                </x-adminlte-textarea>
            </div>
        </div>

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
                                        {{-- <option value="prn"
                                            {{ $itemobat->interval == 'prn' ? 'selected' : null }}>
                                            Sesuai Kebutuhan</option>
                                        <option value="q3h"
                                            {{ $itemobat->interval == 'q3h' ? 'selected' : null }}>
                                            Setiap 3 Jam</option>
                                        <option value="q4h"
                                            {{ $itemobat->interval == 'q4h' ? 'selected' : null }}>
                                            Setiap 4 Jam</option> --}}
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
                                    <input type="text" name="keterangan_obat[]"
                                        value="{{ $itemobat->keterangan }}" placeholder="Keterangan Obat"
                                        class="form-control" multiple>
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
                            <input type="number" name="jumlah[]" placeholder="Jumlah" class="form-control"
                                multiple>
                            <select name="frekuensi[]" class="form-control frekuensilObat">
                                <option selected disabled>Interval</option>
                                <option value="qod">1 x 1</option>
                                <option value="dod">1 x 2</option>
                                <option value="bid">2 x 1</option>
                                <option value="tid">3 x 1</option>
                                <option value="qid">4 x 1</option>
                                <option value="202">2-0-2</option>
                                <option value="303">3-0-3</option>
                                {{-- <option value="prn">Sesuai Kebutuhan</option>
                                <option value="q3h">Setiap 3 Jam</option>
                                <option value="q4h">Setiap 4 Jam</option> --}}
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
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Resep Obat Manual (Free Text)" name="resep_obat"
                    placeholder="Resep Obat Manual (Text)">
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
    <x-slot name="footerSlot">
        @can('dokter')
            <button type="submit" class="btn btn-success" form="formAsesmenDokter">
                <i class="fas fa-save"></i> Simpan Asesmen</button>
        @endcan
            <a href="{{ route('print_asesmen_rajal') }}?kodekunjungan={{ $antrian->kunjungan->kode }}"
                class="btn btn-warning ml-auto" target="_blank"> <i class="fas fa-print"></i> Print</a>
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
