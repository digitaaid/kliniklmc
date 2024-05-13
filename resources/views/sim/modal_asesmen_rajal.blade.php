{{-- anamnesa keperawatan --}}
<div class="card card-info mb-1">
    <a data-toggle="collapse" class="card-header" data-parent="#accordion" href="#collapseTwo">
        <h3 class="card-title">
            Anamnesa Keperawatan
        </h3>
        <div class="card-tools">
            @if ($antrian->asesmenperawat)
                <button type="button" class="btn btn-tool bg-warning">
                    <i class="fas fa-user"></i> {{ $antrian->asesmenperawat->pic ?? null }}
                </button>
                <button type="button" class="btn btn-tool bg-success">
                    <i class="fas fa-check"></i> Sudah Diisi

                </button>
            @else
                <button type="button" class="btn btn-tool bg-danger">
                    <i class="fas fa-times"></i> Belum Diisi
                </button>
            @endif
        </div>
    </a>
    <div id="collapseTwo" class="collapse" role="tabpanel">
        <div class="card-body">
            <form action="{{ route('editasesmenperawat') }}" name="formPerawat" id="formPerawat" method="POST">
                @csrf
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <input type="hidden" name="kodekunjungan" value="{{ $antrian->kunjungan->kode ?? null }}">
                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id ?? null }}">
                <h6>Subjective (S) - Anamnesa</h6>
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
                        <x-adminlte-textarea igroup-size="sm" rows=5 label="Keluhan Utama" name="keluhan_utama"
                            placeholder="Keluhan Utama">
                            {{ $antrian->asesmenperawat->keluhan_utama ?? null }}
                        </x-adminlte-textarea>
                        <div class="row">
                            <div class="col-md-4"><b>Riwayat Pernah Berobat :</b></div>
                            <div class="col-md-3">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="pernahberobat1"
                                        name="pernah_berobat" value="Iya"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pernah_berobat == 'Iya' ? 'checked' : null) : null }}>
                                    <label for="pernahberobat1" class="custom-control-label">Iya</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="pernahberobat2"
                                        name="pernah_berobat" value="Tidak"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pernah_berobat == 'Tidak' ? 'checked' : null) : null }}>
                                    <label for="pernahberobat2" class="custom-control-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan"
                            name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">
                            {{ $antrian->asesmenperawat->riwayat_pengobatan ?? null }}
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Riwayat Penyakit Dahulu"
                            name="riwayat_penyakit" placeholder="Riwayat Penyakit">
                            {{ $antrian->asesmenperawat->riwayat_penyakit ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Riwayat Penyakit Keluarga"
                            name="riwayat_penyakit_keluarga" placeholder="Riwayat Penyakit">
                            {{ $antrian->asesmenperawat->riwayat_penyakit_keluarga ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Riwayat Alergi" name="riwayat_alergi"
                            placeholder="Riwayat Alergi">
                            {{ $antrian->asesmenperawat->riwayat_alergi ?? null }}
                        </x-adminlte-textarea>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Asesmen Nyeri</h6>
                        <img src="{{ asset('bekerwong.png') }}" width="100%">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="skala_nyeri">Skala Nyeri</label>
                            </div>
                            <div class="col-md-2">
                                <x-adminlte-input name="skala_nyeri" type="number" placeholder="Skala"
                                    value="{{ $antrian->asesmenperawat->skala_nyeri ?? 0 }}" />
                            </div>
                            <div class="col-md-7">
                                <x-adminlte-input name="keluhan_nyeri" placeholder="Keluhan Nyeri"
                                    value="{{ $antrian->asesmenperawat->keluhan_nyeri ?? null }}" />
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h6>Asesmen Resiko Jatuh</h6>
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th colspan="2" class="text-center">Assesmen Resiko Jatuh (Up And Go Test)</th>
                            </tr>
                            <tr>
                                <th>Faktor</th>
                                <th>Skala</th>
                            </tr>
                            <tr>
                                <td>a</td>
                                <td>Perhatikan cara berjalan pasien saat akan duduk dikursi. Apakah pasien tampak tidak
                                    seimbang
                                    (
                                    sempoyongan / limbung ) ?</td>
                            </tr>
                            <tr>
                                <td>b</td>
                                <td>Apakah pasien memegang pinggiran kursi atau meja atau benda lain sebagai penopang
                                    saat akan
                                    duduk ?</td>
                            </tr>
                        </table>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="resiko_jatuh">Resiko Jatuh</label>
                            </div>
                            <div class="col-md-9">
                                <x-adminlte-select name="resiko_jatuh">
                                    <option value="Tidak Bersiko (tidak ditemukan a dan b)"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->resiko_jatuh == 'Tidak Bersiko (tidak ditemukan a dan b)' ? 'selected' : null) : null }}>
                                        Tidak Bersiko (tidak ditemukan a dan b)</option>
                                    <option value="Resiko Rendah (ditemukan a atau b)"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->resiko_jatuh == 'Resiko Rendah (ditemukan a atau b)' ? 'selected' : null) : null }}>
                                        Resiko Rendah (ditemukan a atau b)</option>
                                    <option value="Resiko Tinggi (ditemukan a dan b)"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->resiko_jatuh == 'Resiko Tinggi (ditemukan a dan b)' ? 'selected' : null) : null }}>
                                        Resiko Tinggi (ditemukan a dan b)</option>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <h6>Asesmen Status Fungsional</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="alat_bantu">Alat Bantu</label>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-select name="alat_bantu">
                                    <option
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->alat_bantu == 'Tidak Ada' ? 'selected' : null) : null }}>
                                        Tidak
                                        Ada</option>
                                    <option
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->alat_bantu == 'Kursi Roda' ? 'selected' : null) : null }}>
                                        Kursi Roda</option>
                                    <option
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->alat_bantu == 'Tongkat' ? 'selected' : null) : null }}>
                                        Tongkat
                                    </option>
                                    <option
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->alat_bantu == 'Alat Bantu Pendengaran' ? 'selected' : null) : null }}>
                                        Alat Bantu Pendengaran</option>
                                    <option
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->alat_bantu == 'Lain-lain' ? 'selected' : null) : null }}>
                                        Lain-lain</option>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-5">
                                <x-adminlte-input name="alat_bantu_text" placeholder="Alat Bantu Lainnya"
                                    value="{{ $antrian->asesmenperawat->alat_bantu_text ?? null }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="cacat_fisik">Cacat Fisik</label>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-select name="cacat_fisik">
                                    <option
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->cacat_fisik == 'Tidak Ada' ? 'selected' : null) : null }}>
                                        Tidak Ada</option>
                                    <option
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->cacat_fisik == 'Ada' ? 'selected' : null) : null }}>
                                        Ada
                                    </option>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-5">
                                <x-adminlte-input name="cacat_fisik_text" placeholder="Cacat Fisik Lainnya"
                                    value="{{ $antrian->asesmenperawat->cacat_fisik_text ?? null }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Asesmen Glasgow Coma Scale (GCS)</h6>
                        <div class="row">
                            <div class="col-md-5">
                                <label for="respon_buka_mata">Respon Membuka Mata</label>
                            </div>
                            <div class="col-md-7">
                                <x-adminlte-select name="respon_buka_mata">
                                    <option value="4"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_buka_mata == '4' ? 'selected' : null) : null }}>
                                        Spontan</option>
                                    <option value="3"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_buka_mata == '3' ? 'selected' : null) : null }}>
                                        Terhadap Rangsangan Suara</option>
                                    <option value="2"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_buka_mata == '3' ? 'selected' : null) : null }}>
                                        Terhadap Nyeri
                                    </option>
                                    <option value="1"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_buka_mata == '1' ? 'selected' : null) : null }}>
                                        Tidak Ada</option>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <label for="respon_verbal">Respon Verbal</label>
                            </div>
                            <div class="col-md-7">
                                <x-adminlte-select name="respon_verbal">
                                    <option value="5"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_verbal == '5' ? 'selected' : null) : null }}>
                                        Orientasi Baik</option>
                                    <option value="4"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_verbal == '4' ? 'selected' : null) : null }}>
                                        Orientasi Terganggu</option>
                                    <option value="3"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_verbal == '3' ? 'selected' : null) : null }}>
                                        Kata-kata Tidak Jelas</option>
                                    <option value="2"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_verbal == '2' ? 'selected' : null) : null }}>
                                        Suara Tidak Jelas</option>
                                    <option value="1"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_verbal == '1' ? 'selected' : null) : null }}>
                                        Tidak Ada Respon</option>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <label for="respon_motorik">Respon Motorik</label>
                            </div>
                            <div class="col-md-7">
                                <x-adminlte-select name="respon_motorik">
                                    <option value="6"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_motorik == '6' ? 'selected' : null) : null }}>
                                        Mampu Bergerak</option>
                                    <option value="5"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_motorik == '5' ? 'selected' : null) : null }}>
                                        Melokalisasi Nyeri</option>
                                    <option value="4"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_motorik == '4' ? 'selected' : null) : null }}>
                                        Fleksi Mekanik</option>
                                    <option value="3"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_motorik == '3' ? 'selected' : null) : null }}>
                                        Fleksi Abnormal</option>
                                    <option value="2"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_motorik == '2' ? 'selected' : null) : null }}>
                                        Ekstensi</option>
                                    <option value="1"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->respon_motorik == '1' ? 'selected' : null) : null }}>
                                        Tidak Ada Respon</option>
                                </x-adminlte-select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Skrining Gizi MST</h6>
                        <div class="row">
                            <div class="col-md-9">
                                <label for="penurunan_berat_badan">1. Adakah penurunan Berat Badan dalam 6 bulan
                                    terakhir tanpa
                                    usaha
                                    khusus ?</label>
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-select name="penurunan_berat_badan">
                                    <option value="0"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->penurunan_berat_badan == '0' ? 'selected' : null) : null }}>
                                        Tidak
                                    </option>
                                    <option value="2"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->penurunan_berat_badan == '2' ? 'selected' : null) : null }}>
                                        Ragu-ragu
                                    </option>
                                    <option value="1"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->penurunan_berat_badan == '1' ? 'selected' : null) : null }}>
                                        Ya, Turun 1-5 kg
                                    </option>
                                    <option value="2"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->penurunan_berat_badan == '2' ? 'selected' : null) : null }}>
                                        Ya, 6-10 kg
                                    </option>
                                    <option value="3"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->penurunan_berat_badan == '3' ? 'selected' : null) : null }}>
                                        Ya, 11-15 kg
                                    </option>
                                    <option value="4"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->penurunan_berat_badan == '4' ? 'selected' : null) : null }}>
                                        Ya, lebih dari 15 kg
                                    </option>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <label for="asupan_berkurang">2. Apakah asupan makanan berkurang karena berkurangnya
                                    nafsu
                                    makan
                                    ?</label>
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-select name="asupan_berkurang">
                                    <option value="0"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->asupan_berkurang == '0' ? 'selected' : null) : null }}>
                                        Tidak
                                    </option>
                                    <option value="1"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->asupan_berkurang == '1' ? 'selected' : null) : null }}>
                                        Ya</option>
                                </x-adminlte-select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h6>Objective (O) - Tanda Tanda Vital</h6>
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input name="denyut_jantung" label="Denyut Jantung" igroup-size="sm"
                            type="number" placeholder="Denyut Jantung" fgroup-class="row"
                            label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                            value="{{ $antrian->asesmenperawat->denyut_jantung ?? null }}">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-secondary">
                                    bpm
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="pernapasan" label="Pernapasan" igroup-size="sm"
                            placeholder="Pernapasan" fgroup-class="row" label-class="text-left col-5"
                            igroup-size="sm" igroup-class="col-7" type="number"
                            value="{{ $antrian->asesmenperawat->pernapasan ?? null }}">
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
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="suhu" label="Suhu Tubuh" igroup-size="sm" fgroup-class="row"
                            label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                            placeholder="Suhu Tubuh" value="{{ $antrian->asesmenperawat->suhu ?? null }}">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-secondary">
                                    celcius
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="berat_badan" label="Berat Badan" igroup-size="sm" fgroup-class="row"
                            label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                            placeholder="Berat Badan" type="number" oninput="indexBsa()"
                            value="{{ $antrian->asesmenperawat->berat_badan ?? null }}">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-secondary">
                                    kg
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="tinggi_badan" type="number" label="Tinggi Badan" fgroup-class="row"
                            label-class="text-left col-5" igroup-size="sm" igroup-class="col-7" igroup-size="sm"
                            placeholder="Tinggi Badan" oninput="indexBsa()"
                            value="{{ $antrian->asesmenperawat->tinggi_badan ?? null }}">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-secondary">
                                    cm
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="bsa" label="Index BSA (m2)" fgroup-class="row"
                            label-class="text-left col-5" igroup-size="sm" igroup-class="col-7" igroup-size="sm"
                            placeholder="Index BSA (m2)" value="{{ $antrian->asesmenperawat->bsa ?? null }}"
                            readonly>
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-secondary">
                                    kg/m2
                                </div>
                            </x-slot>
                        </x-adminlte-input>

                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Pemeriksaan Fisik Perawat"
                            name="keadaan_tubuh" placeholder="Pemeriksaan Fisik">
                            {{ $antrian->asesmenperawat->keadaan_tubuh ?? null }}
                        </x-adminlte-textarea>
                    </div>
                </div>
                <hr>
                <h6>Assesment (A)</h6>
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Diagnosa Keperawatan"
                            name="diagnosa_keperawatan" placeholder="Diagnosa Keperawatan">
                            {{ $antrian->asesmenperawat->diagnosa_keperawatan ?? null }}
                        </x-adminlte-textarea>
                    </div>
                </div>
                <hr>
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
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Evaluasi Keperawatan"
                            name="evaluasi_keperawatan" placeholder="Evaluasi Keperawatan">
                            {{ $antrian->asesmenperawat->evaluasi_keperawatan ?? null }}
                        </x-adminlte-textarea>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Keluhan Utama" name="keluhan_utama"
                            placeholder="Keluhan Utama">
                            {{ $antrian->asesmenperawat->keluhan_utama ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Penyakit" name="riwayat_penyakit"
                            placeholder="Riwayat Penyakit">
                            {{ $antrian->asesmenperawat->riwayat_penyakit ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Alergi" name="riwayat_alergi"
                            placeholder="Riwayat Alergi">
                            {{ $antrian->asesmenperawat->riwayat_alergi ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan"
                            name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">
                            {{ $antrian->asesmenperawat->riwayat_pengobatan ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Status Psikologi" name="status_psikologi"
                            placeholder="Status Psikologi">
                            {{ $antrian->asesmenperawat->status_psikologi ?? null }}
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <x-adminlte-input name="denyut_jantung" fgroup-class="col-md-6"
                                label="Denyut Jantung (spm)" igroup-size="sm" type="number"
                                placeholder="Denyut Jantung (spm)"
                                value="{{ $antrian->asesmenperawat->denyut_jantung ?? null }}" />
                            <x-adminlte-input name="pernapasan" fgroup-class="col-md-6" label="Pernapasan (spm)"
                                igroup-size="sm" placeholder="Pernapasan (spm)" type="number"
                                value="{{ $antrian->asesmenperawat->pernapasan ?? null }}" />
                            <x-adminlte-input name="sistole" fgroup-class="col-md-6" label="Sistole"
                                igroup-size="sm" placeholder="Sistole" type="number"
                                value="{{ $antrian->asesmenperawat->sistole ?? null }}" />
                            <x-adminlte-input name="distole" fgroup-class="col-md-6" label="Diastole"
                                igroup-size="sm" placeholder="Diastole" type="number"
                                value="{{ $antrian->asesmenperawat->distole ?? null }}" />
                            <x-adminlte-input name="suhu" fgroup-class="col-md-6" label="Suhu Tubuh (celcius)"
                                igroup-size="sm" placeholder="Suhu Tubuh (celcius)"
                                value="{{ $antrian->asesmenperawat->suhu ?? null }}" />
                            <x-adminlte-input name="berat_badan" fgroup-class="col-md-6" label="Berat Badan (kg)"
                                igroup-size="sm" placeholder="Berat Badan (kg)" type="number"
                                value="{{ $antrian->asesmenperawat->berat_badan ?? null }}" />
                            <x-adminlte-input name="tinggi_badan" fgroup-class="col-md-6" type="number"
                                label="Tinggi Badan (cm)" igroup-size="sm" placeholder="Tinggi Badan (cm)"
                                value="{{ $antrian->asesmenperawat->tinggi_badan ?? null }}" />
                            <x-adminlte-input name="bsa" fgroup-class="col-md-6" type="number"
                                label="Index BSA (m2)" igroup-size="sm" placeholder="Index BSA (m2)"
                                value="{{ $antrian->asesmenperawat->bsa ?? null }}" disabled />
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="kesadaran1"
                                    name="tingkat_kesadaran" value="1"
                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 1 ? 'checked' : null) : null }}>
                                <label for="kesadaran1" class="custom-control-label">Sadar
                                    baik</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="kesadaran2"
                                    name="tingkat_kesadaran" value="2"
                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 2 ? 'checked' : null) : null }}>
                                <label for="kesadaran2" class="custom-control-label">Berespon
                                    dengan
                                    kata-kata</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="kesadaran3"
                                    name="tingkat_kesadaran" value="3"
                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 3 ? 'checked' : null) : null }}>
                                <label for="kesadaran3" class="custom-control-label">Hanya
                                    berespons jika
                                    dirangsang nyeri/pain</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="kesadaran4"
                                    name="tingkat_kesadaran" value="4"
                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 4 ? 'checked' : null) : null }}>
                                <label for="kesadaran4" class="custom-control-label">Pasien tidak
                                    sadar/unresponsive </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="kesadaran5"
                                    name="tingkat_kesadaran" value="5"
                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 5 ? 'checked' : null) : null }}>
                                <label for="kesadaran5" class="custom-control-label">Gelisah /
                                    bingung</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="kesadaran6"
                                    name="tingkat_kesadaran" value="6"
                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 6 ? 'checked' : null) : null }}>
                                <label for="kesadaran6" class="custom-control-label">Acute
                                    Confusional
                                    State</label>
                            </div>
                        </div>
                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Pemeriksaan Fisik" name="keadaan_tubuh"
                            placeholder="Tanda Vital Tubuh">
                            {{ $antrian->asesmenperawat->keadaan_tubuh ?? null }}
                        </x-adminlte-textarea>
                    </div>
                </div> --}}
            </form>
            @can('perawat')
                <button type="submit" form="formPerawat" class="btn btn-success mb-1 w-100 withLoad">
                    <i class="fas fa-edit"></i> Simpan & Tanda Tangan Pemeriksaan Perawat
                </button>
            @endcan
        </div>
    </div>
</div>
{{-- asesmen --}}
<div class="card card-info mb-1">
    <a data-toggle="collapse" class="card-header" data-parent="#accordion" href="#collAsesmenRajal">
        <h3 class="card-title">
            Asesmen Rawat Jalan
        </h3>
    </a>
    <div id="collAsesmenRajal" class="collapse" role="tabpanel">
        <div class="card-body">
            @include('form.asesmen_rajal')
        </div>
    </div>
</div>
{{-- pemeriksaan dokter --}}
<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collapseDokter">
        <h3 class="card-title">
            Pemeriksaan Dokter
        </h3>
        <div class="card-tools">
            @if ($antrian->asesmendokter)
                <button type="button" class="btn btn-tool bg-warning">
                    <i class="fas fa-user"></i> {{ $antrian->asesmendokter->pic->name }}
                </button>
                <button type="button" class="btn btn-tool bg-success">
                    <i class="fas fa-check"></i> Sudah Diisi

                </button>
            @else
                <button type="button" class="btn btn-tool bg-danger">
                    <i class="fas fa-times"></i> Belum Diisi
                </button>
            @endif
        </div>
    </a>
    <div id="collapseDokter" class="collapse" role="tabpanel" aria-labelledby="headDokter">
        <div class="card-body">
            <form action="{{ route('editasesmendokter') }}" method="POST">
                @csrf
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <input type="hidden" name="kodekunjungan" value="{{ $antrian->kunjungan->kode ?? null }}">
                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id ?? null }}">
                <h6>Subjective (S) - Anamnesa</h6>
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
                        <x-adminlte-textarea igroup-size="sm" rows=5 label="Keluhan Utama" name="keluhan_utama"
                            placeholder="Keluhan Utama">
                            {{ $antrian->asesmenperawat->keluhan_utama ?? null }}
                        </x-adminlte-textarea>
                        <div class="row">
                            <div class="col-md-4"><b>Riwayat Pernah Berobat :</b></div>
                            <div class="col-md-3">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="pernahberobat1"
                                        name="pernah_berobat" value="Iya"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pernah_berobat == 'Iya' ? 'checked' : null) : null }}>
                                    <label for="pernahberobat1" class="custom-control-label">Iya</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="pernahberobat2"
                                        name="pernah_berobat" value="Tidak"
                                        {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pernah_berobat == 'Tidak' ? 'checked' : null) : null }}>
                                    <label for="pernahberobat2" class="custom-control-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan Perawat"
                            name="riwayat_pengobatan_perawat" placeholder="Riwayat Pengobatan">
                            {{ $antrian->asesmenperawat->riwayat_pengobatan ?? null }}
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Riwayat Penyakit Dahulu"
                            name="riwayat_penyakit" placeholder="Riwayat Penyakit">
                            {{ $antrian->asesmenperawat->riwayat_penyakit ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Riwayat Penyakit Keluarga"
                            name="riwayat_penyakit_keluarga" placeholder="Riwayat Penyakit">
                            {{ $antrian->asesmenperawat->riwayat_penyakit_keluarga ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Riwayat Alergi" name="riwayat_alergi"
                            placeholder="Riwayat Alergi">
                            {{ $antrian->asesmenperawat->riwayat_alergi ?? null }}
                        </x-adminlte-textarea>
                    </div>
                </div>
                <hr>
                <h6>Objective (O) - Tanda Tanda Vital</h6>
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input name="denyut_jantung" label="Denyut Jantung" igroup-size="sm"
                            type="number" placeholder="Denyut Jantung" fgroup-class="row"
                            label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                            value="{{ $antrian->asesmenperawat->denyut_jantung ?? null }}">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-secondary">
                                    bpm
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="pernapasan" label="Pernapasan" igroup-size="sm"
                            placeholder="Pernapasan" fgroup-class="row" label-class="text-left col-5"
                            igroup-size="sm" igroup-class="col-7" type="number"
                            value="{{ $antrian->asesmenperawat->pernapasan ?? null }}">
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
                            label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                            placeholder="Suhu Tubuh" value="{{ $antrian->asesmenperawat->suhu ?? null }}">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-secondary">
                                    celcius
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="berat_badan" label="Berat Badan" igroup-size="sm" fgroup-class="row"
                            label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                            placeholder="Berat Badan" type="number" oninput="indexBsa()"
                            value="{{ $antrian->asesmenperawat->berat_badan ?? null }}">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-secondary">
                                    kg
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="tinggi_badan" type="number" label="Tinggi Badan" fgroup-class="row"
                            label-class="text-left col-5" igroup-size="sm" igroup-class="col-7" igroup-size="sm"
                            placeholder="Tinggi Badan" oninput="indexBsa()"
                            value="{{ $antrian->asesmenperawat->tinggi_badan ?? null }}">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-secondary">
                                    cm
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="bsa" label="Index BSA (m2)" fgroup-class="row"
                            label-class="text-left col-5" igroup-size="sm" igroup-class="col-7" igroup-size="sm"
                            placeholder="Index BSA (m2)" value="{{ $antrian->asesmenperawat->bsa ?? null }}"
                            readonly>
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-secondary">
                                    kg/m2
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
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
                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Pemeriksaan Fisik Perawat"
                            name="keadaan_tubuh" placeholder="Pemeriksaan Fisik">
                            {{ $antrian->asesmenperawat->keadaan_tubuh ?? null }}
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Pemeriksaan Fisik Dokter"
                            name="pemeriksaan_fisik" placeholder="Pemeriksaan Fisik">
                            {{ $antrian->asesmendokter->pemeriksaan_fisik ?? null }}
                        </x-adminlte-textarea>
                    </div>
                </div>
                <hr>
                <h6>Assesment (A) - Diagnosa</h6>
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Diagnosa Keperawatan"
                            name="diagnosa_keperawatan" placeholder="Diagnosa Keperawatan">
                            {{ $antrian->asesmenperawat->diagnosa_keperawatan ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-select name="diagnosa[]" class="diagnosa" label="Diagnosa :" multiple>
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
                        </x-adminlte-select>
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Diagnosa Sekunder"
                            name="catatan_diagnosa" placeholder="Diagnosa Sekunder (Free Text)">
                            {{ $kunjungan->asesmendokter->catatan_diagnosa ?? null }}
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="diagnosa1" class="diagnosaid1" label="Diagnosa Primer ICD-10 : ">
                            @if ($antrian->asesmendokter)
                                @if ($antrian->asesmendokter->diagnosa1)
                                    <option value="{{ $antrian->asesmendokter->diagnosa1 }}" selected>
                                        {{ $antrian->asesmendokter->diagnosa1 }}
                                    </option>
                                @endif
                            @endif
                        </x-adminlte-select>
                        <x-adminlte-select name="diagnosa2[]" class="diagnosaid2" label="Diagnosa Sekunder ICD-10 : "
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
                        </x-adminlte-select>
                    </div>
                </div>
                <hr>
                <h6>Planning (P) - Instruksi & Terapi</h6>
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Instruksi Medis" name="instruksi_medis"
                            placeholder="Instruksi Medis">
                            {{ $kunjungan->asesmendokter->instruksi_medis ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Catatan Dokter" name="rencana_perawatan"
                            placeholder="Rencana Perawatan">
                            {{ $kunjungan->asesmendokter->rencana_perawatan ?? null }}
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Tindakan Medis" name="tindakan_medis"
                            placeholder="Tindakan Medis">
                            {{ $kunjungan->asesmendokter->tindakan_medis ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan"
                            name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">
                            {{ $kunjungan->asesmendokter->riwayat_pengobatan ?? null }}
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
                                                <option value="qod"
                                                    {{ $itemobat->interval == 'qod' ? 'selected' : null }}>
                                                    1 x 1</option>
                                                <option value="dod"
                                                    {{ $itemobat->interval == 'dod' ? 'selected' : null }}>
                                                    1 x 2</option>
                                                <option value="bid"
                                                    {{ $itemobat->interval == 'bid' ? 'selected' : null }}>
                                                    2 x 1</option>
                                                <option value="tid"
                                                    {{ $itemobat->interval == 'tid' ? 'selected' : null }}>
                                                    3 x 1</option>
                                                <option value="qid"
                                                    {{ $itemobat->interval == 'qid' ? 'selected' : null }}>
                                                    4 x 1</option>
                                                <option value="202"
                                                    {{ $itemobat->interval == '202' ? 'selected' : null }}>
                                                    2-0-2</option>
                                                <option value="303"
                                                    {{ $itemobat->interval == '303' ? 'selected' : null }}>
                                                    3-0-3</option>
                                            </select>
                                            <select name="waktuobat[]" class="form-control waktuObat">
                                                <option selected>Waktu Obat</option>
                                                <option value="pc"
                                                    {{ $itemobat->waktu == 'pc' ? 'selected' : null }}>
                                                    Setelah Makan</option>
                                                <option value="ac"
                                                    {{ $itemobat->waktu == 'ac' ? 'selected' : null }}>
                                                    Sebelum Makan</option>
                                                <option value="hs"
                                                    {{ $itemobat->waktu == 'hs' ? 'selected' : null }}>
                                                    Sebelum Tidur</option>
                                                <option value="int"
                                                    {{ $itemobat->waktu == 'int' ? 'selected' : null }}>
                                                    Diantara Waktu Makan</option>
                                            </select>
                                            <input type="text" name="keterangan_obat[]"
                                                value="{{ $itemobat->keterangan }}" placeholder="Keterangan Obat"
                                                class="form-control" multiple>
                                            <button type="button" class="btn btn-xs btn-danger"
                                                id="deleteRowObat"><i class="fas fa-trash "></i>
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
                @can('dokter')
                    <button type="submit" class="btn btn-success mb-1 w-100 withLoad">
                        <i class="fas fa-edit"></i> Simpan & Tanda Tangan Pemeriksaan Dokter</button>
                @endcan
            </form>
        </div>
    </div>
</div>
<x-adminlte-modal id="modalAsesmenRajal" title="Asesmen Rajal" size="xl" icon="fas fa-file-medical"
    theme="success">
    @include('form.asesmen_rajal')
    <x-slot name="footerSlot">
        <a href="{{ route('print_asesmen_rajal') }}?kodekunjungan={{ $antrian->kunjungan->kode }}"
            class="btn btn-warning ml-auto" target="_blank"> <i class="fas fa-print"></i> Print</a>
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
<x-adminlte-modal id="modalPerawatSelesai" title="Verifikasi Asesmen Rajal" size="xl"
    icon="fas fa-file-medical" theme="success">
    @include('form.asesmen_rajal')
    <x-slot name="footerSlot">
        <a href="{{ route('antrianperawat') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
            class="btn btn-success withLoad">
            <i class="fas fa-arrow-left"></i> Selesai & Kembali
        </a>
        <a href="{{ route('print_asesmen_rajal') }}?kodekunjungan={{ $antrian->kunjungan->kode }}"
            class="btn btn-warning mr-auto" target="_blank"> <i class="fas fa-print"></i> Print</a>
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    {{-- index bsa --}}
    <script>
        function indexBsa() {
            var bb = $('#berat_badan').val() ? $('#berat_badan').val() : 0;
            var tb = $('#tinggi_badan').val() ? $('#tinggi_badan').val() : 0;
            var bsa = (Math.sqrt(parseInt(bb) * parseInt(tb) / 3600)).toFixed(2);
            $('#bsa').val(bsa);
        }
    </script>
    {{-- diagnosa --}}
    <script>
        $(function() {
            $(".diagnosaid1").select2({
                theme: "bootstrap4",
                placeholder: "Diagnosa Primer ICD-10",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('ref_diagnosa_api') }}",
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
            $(".diagnosaid2").select2({
                placeholder: "Diagnosa Sekunder ICD-10",
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_diagnosa_api') }}",
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
            $(".diagnosa").select2({
                theme: "bootstrap4",
                placeholder: "Diagnosa Klinik",
                ajax: {
                    url: "{{ route('diagnosa.search') }}",
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
    {{-- input obat --}}
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
        function btnAsesmenRajal() {
            $.LoadingOverlay("show");
            $('#modalAsesmenRajal').modal('show');
            $.LoadingOverlay("hide");
        }

        function modalPerawatSelesai() {
            $.LoadingOverlay("show");
            $('#modalPerawatSelesai').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endpush
