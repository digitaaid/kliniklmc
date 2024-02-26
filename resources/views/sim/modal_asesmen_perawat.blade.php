<x-adminlte-modal id="modalAsesmenPerawat" title="Pengkajian Awal / Asesmen Perawat" size="xl"
    icon="fas fa-hand-holding-medical" theme="success">
    <form action="{{ route('editasesmenperawat') }}" name="formPerawat" id="formPerawat" method="POST">
        @csrf
        <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
        <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
        <input type="hidden" name="kodekunjungan" value="{{ $antrian->kunjungan->kode ?? null }}">
        <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id ?? null }}">
        <h6>Information</h6>
        @include('sim.antrian_profil3')
        <h6>Subjective (S) - Keluhan Utama, Nyeri & Resiko Jatuh</h6>
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-select name="sumber_data" label="Sumber Data" fgroup-class="row"
                    label-class="text-left col-3" igroup-size="sm" igroup-class="col-9">
                    <option>Pasien Sendiri / Autoanamase</option>
                    <option>Keluarga / Alloanamnesa</option>
                </x-adminlte-select>
                <x-adminlte-textarea required igroup-size="sm" rows=3 label="Keluhan Utama" name="keluhan_utama"
                    placeholder="Keluhan Utama">
                    {{ $antrian->asesmenperawat->keluhan_utama ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea required igroup-size="sm" rows=3 label="Riwayat Penyakit" name="riwayat_penyakit"
                    placeholder="Riwayat Penyakit">
                    {{ $antrian->asesmenperawat->riwayat_penyakit ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea required igroup-size="sm" rows=3 label="Riwayat Penyakit Keluarga"
                    name="riwayat_penyakit_keluarga" placeholder="Riwayat Penyakit">
                    {{ $antrian->asesmenperawat->riwayat_penyakit_keluarga ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea required igroup-size="sm" rows=3 label="Riwayat Alergi" name="riwayat_alergi"
                    placeholder="Riwayat Alergi">
                    {{ $antrian->asesmenperawat->riwayat_alergi ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea required igroup-size="sm" rows=3 label="Riwayat Pengobatan"
                    name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">
                    {{ $antrian->asesmenperawat->riwayat_pengobatan ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('skalanyeri.png') }}" width="100%">
                <div class="row">
                    <div class="col-md-3">
                        <label for="skala_nyeri">Skala Nyeri</label>
                    </div>
                    <div class="col-md-2">
                        <x-adminlte-input required name="skala_nyeri" type="number" placeholder="Skala"
                            value="{{ $antrian->asesmenperawat->skala_nyeri ?? null }}" />
                    </div>
                    <div class="col-md-7">
                        <x-adminlte-input required name="keluhan_nyeri" placeholder="Keluhan Nyeri"
                            value="{{ $antrian->asesmenperawat->keluhan_nyeri ?? null }}" />
                    </div>
                </div>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th colspan="2" class="text-center">Assesmen Resiko Jatuh</th>
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
                        <x-adminlte-select required name="resiko_jatuh">
                            <option value="Tidak Bersiko">Tidak Bersiko (tidak ditemukan a dan b)</option>
                            <option value="Resiko Rendah">Resiko Rendah (ditemukan a atau b)</option>
                            <option value="Resiko Tinggi">Resiko Tinggi (ditemukan a dan b)</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="alat_bantu">Alat Bantu</label>
                    </div>
                    <div class="col-md-4">
                        <x-adminlte-select required name="alat_bantu">
                            <option>Tidak Ada</option>
                            <option>Kursi Roda</option>
                            <option>Tongkat</option>
                            <option>Lain-lain</option>
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-5">
                        <x-adminlte-input required name="alat_bantu_text" placeholder="Alat Bantu Lainnya"
                            value="{{ $antrian->asesmenperawat->alat_bantu_text ?? null }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="cacat_fisik">Cacat Fisik</label>
                    </div>
                    <div class="col-md-4">
                        <x-adminlte-select required name="cacat_fisik">
                            <option>Tidak Ada</option>
                            <option>Ada</option>
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-5">
                        <x-adminlte-input required name="cacat_fisik_text" placeholder="Cacat Fisik Lainnya"
                            value="{{ $antrian->asesmenperawat->cacat_fisik_text ?? null }}" />
                    </div>
                </div>
            </div>
        </div>
        <h6>Subjective (S) - Psikologi, Sosial, dan Ekonomi</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label for="status_psikologi">Status Psikologi</label>
                    </div>
                    <div class="col-md-8">
                        <x-adminlte-select name="status_psikologi">
                            <option>Tidak ada kelainan</option>
                            <option>Cemas</option>
                            <option>Takut</option>
                            <option>Marah</option>
                            <option>Sedih</option>
                            <option>Lain-lain</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="tinggal_dengan">Tinggal Dengan</label>
                    </div>
                    <div class="col-md-8">
                        <x-adminlte-select name="tinggal_dengan">
                            <option>Orang Tua</option>
                            <option>Istri / Suami</option>
                            <option>Anak</option>
                            <option>Mandiri</option>
                            <option>Saudara</option>
                            <option>Wali</option>
                            <option>Paman / Bibi</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="hubungan_keluarga">Hubungan Keluarga</label>
                    </div>
                    <div class="col-md-8">
                        <x-adminlte-select name="hubungan_keluarga">
                            <option>Baik</option>
                            <option>Tidak Baik</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="ekonomi">Ekonomi</label>
                    </div>
                    <div class="col-md-8">
                        <x-adminlte-select name="ekonomi">
                            <option>Baik</option>
                            <option>Tidak Baik</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="edukasi">Edukasi Diberikan Kpd</label>
                    </div>
                    <div class="col-md-8">
                        <x-adminlte-select name="edukasi">
                            <option>Keluarga</option>
                            <option>Pasien</option>
                            <option>Pengantar</option>
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
                            <option>Tidak bekerja</option>
                            <option>PNS</option>
                            <option>TNI/POLRI</option>
                            <option>BUMN</option>
                            <option>Dokter</option>
                            <option>Guru</option>
                            <option>Pegawai Swasta</option>
                            <option>Wirausaha</option>
                            <option>Lain-lain</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="agama">Agama</label>
                    </div>
                    <div class="col-md-9">
                        <x-adminlte-select name="agama">
                            <option>Islam</option>
                            <option>Kristen (Protestan)</option>
                            <option>Katolik</option>
                            <option>Hindu</option>
                            <option>Budha</option>
                            <option>Konghucu</option>
                            <option>Penghayat</option>
                            <option>Lain-lain</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="pendidikan">Pendidikan</label>
                    </div>
                    <div class="col-md-9">
                        <x-adminlte-select name="pendidikan">
                            <option>Tidak sekolah</option>
                            <option>SD</option>
                            <option>SLTP sederajat</option>
                            <option>SLTA sederajat</option>
                            <option>D1-D3 sederajat</option>
                            <option>D4</option>
                            <option>S1</option>
                            <option>S2</option>
                            <option>S3</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="status_nikah">Status Nikah</label>
                    </div>
                    <div class="col-md-9">
                        <x-adminlte-select name="status_nikah">
                            <option>Belum Kawin</option>
                            <option>Kawin</option>
                            <option>Cerai Hidup</option>
                            <option>Cerai Mati</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="bahasa">Bahasa</label>
                    </div>
                    <div class="col-md-9">
                        <x-adminlte-select name="bahasa">
                            <option>Indonesia</option>
                            <option>Jawa</option>
                            <option>Sunda</option>
                            <option>Inggris</option>
                            <option>Isyarat</option>
                            <option>Lain-lain</option>
                        </x-adminlte-select>
                    </div>
                </div>

            </div>

        </div>
        <h6>Subjective (S) - Skrining Gizi</h6>
        <div class="row">
            <div class="col-md-9">
                <label for="status_psikologi">1. Apakah pasien mengalami penurunan berat badan yang tidak
                    diinginkan dalam 6 bulan terakhir ?</label>
            </div>
            <div class="col-md-3">
                <x-adminlte-select name="status_psikologi">
                    <option>Tidak</option>
                    <option>Ya</option>
                </x-adminlte-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <label for="status_psikologi">2. Apakah asupan makanan berkurang karena berkurangnya nafsu makan
                    ?</label>
            </div>
            <div class="col-md-3">
                <x-adminlte-select name="status_psikologi">
                    <option>Tidak</option>
                    <option>Ya</option>
                </x-adminlte-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <label for="status_psikologi">3. Apakah pasien dengan diagnosa khusus : Penyakit
                    DM/Ginjal/Hati/Paru/Stroke/Kanker/Penurunan imun/lainnya ?</label>
            </div>
            <div class="col-md-3">
                <x-adminlte-select name="status_psikologi">
                    <option>Tidak</option>
                    <option>Ya</option>
                </x-adminlte-select>
            </div>
        </div>
        <h6>Objective (O)</h6>
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input required name="denyut_jantung" label="Denyut Jantung" igroup-size="sm"
                    type="number" placeholder="Denyut Jantung" fgroup-class="row" label-class="text-left col-5"
                    igroup-size="sm" igroup-class="col-7"
                    value="{{ $antrian->asesmenperawat->denyut_jantung ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            bpm
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input required name="pernapasan" label="Pernapasan" igroup-size="sm"
                    placeholder="Pernapasan" fgroup-class="row" label-class="text-left col-5" igroup-size="sm"
                    igroup-class="col-7" type="number" value="{{ $antrian->asesmenperawat->pernapasan ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            spm
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input required name="sistole" label="Sistole" igroup-size="sm" placeholder="Sistole"
                    fgroup-class="row" label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                    type="number" value="{{ $antrian->asesmenperawat->sistole ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            mmHg
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input required name="distole" label="Diastole" igroup-size="sm" placeholder="Diastole"
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
                <x-adminlte-input required name="suhu" label="Suhu Tubuh" igroup-size="sm" fgroup-class="row"
                    label-class="text-left col-5" igroup-size="sm" igroup-class="col-7" placeholder="Suhu Tubuh"
                    value="{{ $antrian->asesmenperawat->suhu ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            celcius
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input required name="berat_badan" label="Berat Badan" igroup-size="sm"
                    fgroup-class="row" label-class="text-left col-5" igroup-size="sm" igroup-class="col-7"
                    placeholder="Berat Badan" type="number"
                    value="{{ $antrian->asesmenperawat->berat_badan ?? null }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-secondary">
                            kg
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input required name="tinggi_badan" type="number" label="Tinggi Badan"
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
        <x-adminlte-textarea required igroup-size="sm" rows=4 label="Tanda Vital Tubuh" name="keadaan_tubuh"
            placeholder="Tanda Vital Tubuh">
            {{ $antrian->asesmenperawat->keadaan_tubuh ?? null }}
        </x-adminlte-textarea>
        <h6>Analysis (A)</h6>
        <x-adminlte-textarea required igroup-size="sm" rows=3 label="Diagnosa Keperawatan"
            name="diagnosa_keperawatan" placeholder="Diagnosa Masuk">
            {{ $antrian->asesmenperawat->diagnosa_keperawatan ?? null }}
        </x-adminlte-textarea>
        <h6>Planning (P)</h6>
        <x-adminlte-textarea required igroup-size="sm" rows=3 label="Rencana Keperawatan" name="rencana_keperawatan"
            placeholder="Rencana Keperawatan">
            {{ $antrian->asesmenperawat->rencana_keperawatan ?? null }}
        </x-adminlte-textarea>
        <x-adminlte-textarea required igroup-size="sm" rows=3 label="Tindakan Keperawatan"
            name="tindakan_keperawatan" placeholder="Tindakan Keperawatan">
            {{ $antrian->asesmenperawat->tindakan_keperawatan ?? null }}
        </x-adminlte-textarea>
        <x-adminlte-textarea required igroup-size="sm" rows=3 label="Evaluasi Keperawatan"
            name="evaluasi_keperawatan" placeholder="Evaluasi Keperawatan">
            {{ $antrian->asesmenperawat->evaluasi_keperawatan ?? null }}
        </x-adminlte-textarea>
    </form>
    <x-slot name="footerSlot">
        <button type="submit" form="formPerawat" class="btn btn-success">
            <i class="fas fa-edit"></i> Simpan Asesmen
        </button>
        <button class="btn btn-warning ml-auto">
            <i class="fas fa-print"></i> Print
        </button>
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
