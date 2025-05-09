<x-adminlte-modal id="modalAsesmenPerawat" title="Asesmen Perawat" size="xl" icon="fas fa-hand-holding-medical"
    theme="success">
    <form action="{{ route('editasesmenperawat') }}" name="formPerawat" id="formPerawat" method="POST">
        @csrf
        <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
        <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
        <input type="hidden" name="kodekunjungan" value="{{ $antrian->kunjungan->kode ?? null }}">
        <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id ?? null }}">
        <h6>Subjective (S) - Keluhan Utama & Riwayat Penyakit</h6>
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
                            <input class="custom-control-input" type="radio" id="pernahberobat1" name="pernah_berobat"
                                value="Iya"
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pernah_berobat == 'Iya' ? 'checked' : null) : null }}>
                            <label for="pernahberobat1" class="custom-control-label">Iya</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="pernahberobat2" name="pernah_berobat"
                                value="Tidak"
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pernah_berobat == 'Tidak' ? 'checked' : null) : null }}>
                            <label for="pernahberobat2" class="custom-control-label">Tidak</label>
                        </div>
                    </div>


                </div>
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan" name="riwayat_pengobatan"
                    placeholder="Riwayat Pengobatan">
                    {{ $antrian->asesmenperawat->riwayat_pengobatan ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Penyakit Dahulu" name="riwayat_penyakit"
                    placeholder="Riwayat Penyakit">
                    {{ $antrian->asesmenperawat->riwayat_penyakit ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Penyakit Keluarga"
                    name="riwayat_penyakit_keluarga" placeholder="Riwayat Penyakit">
                    {{ $antrian->asesmenperawat->riwayat_penyakit_keluarga ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Alergi" name="riwayat_alergi"
                    placeholder="Riwayat Alergi">
                    {{ $antrian->asesmenperawat->riwayat_alergi ?? null }}
                </x-adminlte-textarea>
            </div>
        </div>
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
                            value="{{ $antrian->asesmenperawat->skala_nyeri ?? null }}" />
                    </div>
                    <div class="col-md-7">
                        <x-adminlte-input name="keluhan_nyeri" placeholder="Keluhan Nyeri"
                            value="{{ $antrian->asesmenperawat->keluhan_nyeri ?? null }}" />
                    </div>
                </div>
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
                        <td>Perhatikan cara berjalan pasien saat akan duduk dikursi. Apakah pasien tampak tidak seimbang
                            (
                            sempoyongan / limbung ) ?</td>
                    </tr>
                    <tr>
                        <td>b</td>
                        <td>Apakah pasien memegang pinggiran kursi atau meja atau benda lain sebagai penopang saat akan
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
        <h6>Asesmen Status Psikologi</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label for="status_psikologi">Status Psikologi</label>
                    </div>
                    <div class="col-md-8">
                        <x-adminlte-select name="status_psikologi">
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->status_psikologi == 'Tidak Ada Kelainan' ? 'selected' : null) : null }}>
                                Tidak Ada Kelainan</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->status_psikologi == 'Cemas' ? 'selected' : null) : null }}>
                                Cemas</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->status_psikologi == 'Takut' ? 'selected' : null) : null }}>
                                Takut</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->status_psikologi == 'Marah' ? 'selected' : null) : null }}>
                                Marah</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->status_psikologi == 'Sedih' ? 'selected' : null) : null }}>
                                Sedih</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->status_psikologi == 'Lain-lain' ? 'selected' : null) : null }}>
                                Lain-lain</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="tinggal_dengan">Tinggal Dengan</label>
                    </div>
                    <div class="col-md-8">
                        <x-adminlte-select name="tinggal_dengan">
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tinggal_dengan == 'Orang Tua' ? 'selected' : null) : null }}>
                                Orang Tua</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tinggal_dengan == 'Istri / Suami' ? 'selected' : null) : null }}>
                                Istri / Suami</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tinggal_dengan == 'Anak' ? 'selected' : null) : null }}>
                                Anak
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tinggal_dengan == 'Mandiri' ? 'selected' : null) : null }}>
                                Mandiri</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tinggal_dengan == 'Saudara' ? 'selected' : null) : null }}>
                                Saudara</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tinggal_dengan == 'Wali' ? 'selected' : null) : null }}>
                                Wali
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tinggal_dengan == 'Paman / Bibi' ? 'selected' : null) : null }}>
                                Paman / Bibi</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="hubungan_keluarga">Hubungan Keluarga</label>
                    </div>
                    <div class="col-md-8">
                        <x-adminlte-select name="hubungan_keluarga">
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->hubungan_keluarga == 'Baik' ? 'selected' : null) : null }}>
                                Baik</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->hubungan_keluarga == 'Tidak Baik' ? 'selected' : null) : null }}>
                                Tidak Baik</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="ekonomi">Ekonomi</label>
                    </div>
                    <div class="col-md-8">
                        <x-adminlte-select name="ekonomi">
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->ekonomi == 'Baik' ? 'selected' : null) : null }}>
                                Baik</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->ekonomi == 'Tidak Baik' ? 'selected' : null) : null }}>
                                Tidak
                                Baik</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="edukasi">Edukasi Diberikan Kpd</label>
                    </div>
                    <div class="col-md-8">
                        <x-adminlte-select name="edukasi">
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->edukasi == 'Pasien' ? 'selected' : null) : null }}>
                                Pasien
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->edukasi == 'Keluarga' ? 'selected' : null) : null }}>
                                Keluarga
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->edukasi == 'Pengantar' ? 'selected' : null) : null }}>
                                Pengantar</option>
                        </x-adminlte-select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label for="pekerjaan">Pekerjaan</label>
                    </div>
                    <div class="col-md-9">
                        <x-adminlte-select name="pekerjaan">
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pekerjaan == 'Tidak bekerja' ? 'selected' : null) : null }}>
                                Tidak bekerja</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pekerjaan == 'PNS' ? 'selected' : null) : null }}>
                                PNS</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pekerjaan == 'TNI/POLRI' ? 'selected' : null) : null }}>
                                TNI/POLRI</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pekerjaan == 'BUMN' ? 'selected' : null) : null }}>
                                BUMN
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pekerjaan == 'Dokter' ? 'selected' : null) : null }}>
                                Dokter
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pekerjaan == 'Guru' ? 'selected' : null) : null }}>
                                Guru
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pekerjaan == 'Pegawai Swasta' ? 'selected' : null) : null }}>
                                Pegawai Swasta</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pekerjaan == 'Wirausaha' ? 'selected' : null) : null }}>
                                Wirausaha</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pekerjaan == 'Lain-lain' ? 'selected' : null) : null }}>
                                Lain-lain</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="agama">Agama</label>
                    </div>
                    <div class="col-md-9">
                        <x-adminlte-select name="agama">
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->agama == 'Islam' ? 'selected' : null) : null }}>
                                Islam</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->agama == 'Kristen (Protestan)' ? 'selected' : null) : null }}>
                                Kristen (Protestan)</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->agama == 'Katolik' ? 'selected' : null) : null }}>
                                Katolik
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->agama == 'Hindu' ? 'selected' : null) : null }}>
                                Hindu</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->agama == 'Budha' ? 'selected' : null) : null }}>
                                Budha</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->agama == 'Konghucu' ? 'selected' : null) : null }}>
                                Konghucu
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->agama == 'Penghayat' ? 'selected' : null) : null }}>
                                Penghayat
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->agama == 'Lain-lain' ? 'selected' : null) : null }}>
                                Lain-lain
                            </option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="pendidikan">Pendidikan</label>
                    </div>
                    <div class="col-md-9">
                        <x-adminlte-select name="pendidikan">
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pendidikan == 'Tidak sekolah' ? 'selected' : null) : null }}>
                                Tidak sekolah</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pendidikan == 'SD' ? 'selected' : null) : null }}>
                                SD</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pendidikan == 'SLTP sederajat' ? 'selected' : null) : null }}>
                                SLTP sederajat</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pendidikan == 'SLTA sederajat' ? 'selected' : null) : null }}>
                                SLTA sederajat</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pendidikan == 'D1-D3 sederajat' ? 'selected' : null) : null }}>
                                D1-D3 sederajat</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pendidikan == 'D4' ? 'selected' : null) : null }}>
                                D4</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pendidikan == 'S1' ? 'selected' : null) : null }}>
                                S1</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pendidikan == 'S2' ? 'selected' : null) : null }}>
                                S2</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->pendidikan == 'S3' ? 'selected' : null) : null }}>
                                S3</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="status_nikah">Status Nikah</label>
                    </div>
                    <div class="col-md-9">
                        <x-adminlte-select name="status_nikah">
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->status_nikah == 'Belum Kawin' ? 'selected' : null) : null }}>
                                Belum Kawin</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->status_nikah == 'Kawin' ? 'selected' : null) : null }}>
                                Kawin
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->status_nikah == 'Cerai Hidup' ? 'selected' : null) : null }}>
                                Cerai Hidup</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->status_nikah == 'Cerai Mati' ? 'selected' : null) : null }}>
                                Cerai Mati</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="bahasa">Bahasa</label>
                    </div>
                    <div class="col-md-9">
                        <x-adminlte-select name="bahasa">
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->bahasa == 'Indonesia' ? 'selected' : null) : null }}>
                                Indonesia</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->bahasa == 'Jawa' ? 'selected' : null) : null }}>
                                Jawa
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->bahasa == 'Sunda' ? 'selected' : null) : null }}>
                                Sunda
                            </option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->bahasa == 'Inggris' ? 'selected' : null) : null }}>
                                Inggris</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->bahasa == 'Isyarat' ? 'selected' : null) : null }}>
                                Isyarat</option>
                            <option
                                {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->bahasa == 'Lain-lain' ? 'selected' : null) : null }}>
                                Lain-lain</option>
                        </x-adminlte-select>
                    </div>
                </div>

            </div>
        </div>
        <h6>Skrining Gizi MST</h6>
        <div class="row">
            <div class="col-md-9">
                <label for="penurunan_berat_badan">1. Adakah penurunan Berat Badan dalam 6 bulan terakhir tanpa usaha
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
                <label for="asupan_berkurang">2. Apakah asupan makanan berkurang karena berkurangnya nafsu makan
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
        <h6>Objective (O) - Tanda Vital</h6>
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
                <x-adminlte-input name="pernapasan" label="Pernapasan" igroup-size="sm" placeholder="Pernapasan"
                    fgroup-class="row" label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                    type="number" value="{{ $antrian->asesmenperawat->pernapasan ?? null }}">
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
                <x-adminlte-input name="berat_badan" label="Berat Badan" igroup-size="sm" fgroup-class="row"
                    label-class="text-left col-5" igroup-size="sm" igroup-class="col-7" placeholder="Berat Badan"
                    type="number" oninput="indexBsa()"
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
        <x-adminlte-textarea igroup-size="sm" rows=4 label="Pemeriksaan Fisik" name="keadaan_tubuh"
            placeholder="Pemeriksaan Fisik">
            {{ $antrian->asesmenperawat->keadaan_tubuh ?? null }}
        </x-adminlte-textarea>
        <b>Status Lokalis : </b><br>
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('statuslokalis.png') }}" width="100%" alt="" srcset=""
                    onclick="btnStatusLolkalis()">
            </div>
            <div class="col-md-6">
            </div>
        </div>
        {{-- <h6>Objective (O) - Laboratorium, Radiologi, & Penunjang Lainnya</h6>
        <div class="row">
            <div class="col-md-4">
                <x-adminlte-textarea  igroup-size="sm" rows=4 label="Hasil Pemeriksaan Laboratorium"
                    name="pemeriksaan_lab" placeholder="Hasil Pemeriksaan Laboratorium">
                    {{ $antrian->asesmenperawat->pemeriksaan_lab ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-4">
                <x-adminlte-textarea  igroup-size="sm" rows=4 label="Hasil Pemeriksaan Radiologi"
                    name="pemeriksaan_rad" placeholder="Hasil Pemeriksaan Radiologi">
                    {{ $antrian->asesmenperawat->pemeriksaan_rad ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-4">
                <x-adminlte-textarea  igroup-size="sm" rows=4 label="Hasil Pemeriksaan Penunjang Lainnya"
                    name="pemeriksaan_penunjang" placeholder="Hasil Pemeriksaan Penunjang Lainnya">
                    {{ $antrian->asesmenperawat->pemeriksaan_penunjang ?? null }}
                </x-adminlte-textarea>
            </div>
        </div> --}}
        <h6>Analysis (A)</h6>
        <x-adminlte-textarea igroup-size="sm" rows=3 label="Diagnosa Keperawatan" name="diagnosa_keperawatan"
            placeholder="Diagnosa Keperawatan">
            {{ $antrian->asesmenperawat->diagnosa_keperawatan ?? null }}
        </x-adminlte-textarea>
        <h6>Planning (P)</h6>
        <x-adminlte-textarea igroup-size="sm" rows=3 label="Rencana Keperawatan" name="rencana_keperawatan"
            placeholder="Rencana Keperawatan">
            {{ $antrian->asesmenperawat->rencana_keperawatan ?? null }}
        </x-adminlte-textarea>
        <x-adminlte-textarea igroup-size="sm" rows=3 label="Tindakan Keperawatan" name="tindakan_keperawatan"
            placeholder="Tindakan Keperawatan">
            {{ $antrian->asesmenperawat->tindakan_keperawatan ?? null }}
        </x-adminlte-textarea>
        <x-adminlte-textarea igroup-size="sm" rows=3 label="Evaluasi Keperawatan" name="evaluasi_keperawatan"
            placeholder="Evaluasi Keperawatan">
            {{ $antrian->asesmenperawat->evaluasi_keperawatan ?? null }}
        </x-adminlte-textarea>
    </form>
    <x-slot name="footerSlot">
        @can('perawat')
            <button type="submit" form="formPerawat" class="btn btn-success">
                <i class="fas fa-edit"></i> Simpan Asesmen
            </button>
        @endcan
        <a href="{{ route('print_asesmen_rajal') }}?kodekunjungan={{ $antrian->kunjungan->kode }}"
            class="btn btn-warning ml-auto" target="_blank"> <i class="fas fa-print"></i> Print</a>
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
<x-adminlte-modal id="modalttd" title="Tanda Tangan Resume Ranap" theme="warning" icon="fas fa-file-medical"
    size='lg'>
    {{-- <form id="formttd" action="" name="formttd" method="POST">
        @csrf
        <input type="hidden" name="norm" value="{{ $antrian->norm }}">
        <input type="hidden" name="kode_kunjungan" value="{{ $antrian->kunjungan->kode }}">
        <input type="hidden" id="ttd_image64" name="image">
        <div class="signature-component">
            <canvas id="signature-pad" width="400" height="200"></canvas>
            <div>
                <span class="btn btn-danger mt-1" id="clear">Clear</span>
            </div>
        </div>
    </form> --}}
    <div id="signature-pad" class="signature-pad">
        <div class="signature-pad--body">
            <canvas></canvas>
        </div>
        <div class="signature-pad--footer">
            <div class="description">Sign above</div>

            <div class="signature-pad--actions">
                <div class="column">
                    <form action="#" enctype="multipart/form-data">
                        <label for="fileupload" id="buttonlabel">
                            <span role="button" aria-controls="filename" tabindex="0">
                                Choose a background image
                            </span>
                        </label>
                        <input type="file" id="fileupload" accept="image/*">
                    </form>
                    <button type="button" class="button clear" data-action="clear">Clear</button>
                    <button type="button" class="button" data-action="change-background-color">Change background
                        color</button>
                    <button type="button" class="button" data-action="change-color">Change color</button>
                    <button type="button" class="button" data-action="change-width">Change width</button>
                    <button type="button" class="button" data-action="undo">Undo</button>

                </div>
                <div class="column">
                    <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                    <button type="button" class="button save" data-action="save-jpg">Save as JPG</button>
                    <button type="button" class="button save" data-action="save-svg">Save as SVG</button>
                    <button type="button" class="button save" data-action="save-svg-with-background">Save as SVG
                        with
                        background</button>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="footerSlot">
        <button class="btn btn-success mr-auto" onclick="simpanttd()"><i class="fas fa-save"></i>
            Simpan</button>
        <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    <script>
        function indexBsa() {
            var bb = $('#berat_badan').val() ? $('#berat_badan').val() : 0;
            var tb = $('#tinggi_badan').val() ? $('#tinggi_badan').val() : 0;
            var bsa = (parseInt(bb) * parseInt(tb) / 3600).toFixed(2);
            $('#bsa').val(bsa);
        }

        function btnStatusLolkalis() {
            $.LoadingOverlay("show");
            $('#modalttd').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endpush
