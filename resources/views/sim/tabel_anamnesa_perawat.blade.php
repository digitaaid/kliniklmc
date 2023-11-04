<div class="card card-info mb-1">
    <a data-toggle="collapse" class="card-header" data-parent="#accordion" href="#collapseTwo">
        <h3 class="card-title">
            Anamnesa Keperawatan
        </h3>
        <div class="card-tools">
            @if ($antrian->asesmenperawat)
                Sudah Diisi Oleh
                {{ $antrian->asesmenperawat->pic->name }}
                {{ $antrian->asesmenperawat->created_at }}
                <i class="fas fa-check-circle"></i>
            @else
                Belum Diisi <i class="fas fa-times-circle"></i>
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
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Keluhan Utama" name="keluhan_utama"
                            placeholder="Keluhan Utama">
                            {{ $antrian->asesmenperawat->keluhan_utama ?? null }}
                        </x-adminlte-textarea>
                        {{-- {{ dd($antrian->asesmenperawat) }} --}}
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
                            <x-adminlte-input name="denyut_jantung" fgroup-class="col-md-6" label="Denyut Jantung (spm)"
                                igroup-size="sm" type="number" placeholder="Denyut Jantung (spm)"
                                value="{{ $antrian->asesmenperawat->denyut_jantung ?? null }}" />
                            <x-adminlte-input name="pernapasan" fgroup-class="col-md-6" label="Pernapasan (spm)"
                                igroup-size="sm" placeholder="Pernapasan (spm)" type="number"
                                value="{{ $antrian->asesmenperawat->pernapasan ?? null }}" />
                            <x-adminlte-input name="sistole" fgroup-class="col-md-6" label="Sistole" igroup-size="sm"
                                placeholder="Sistole" type="number"
                                value="{{ $antrian->asesmenperawat->sistole ?? null }}" />
                            <x-adminlte-input name="distole" fgroup-class="col-md-6" label="Diastole" igroup-size="sm"
                                placeholder="Diastole" type="number"
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
                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Tanda Vital Tubuh" name="keadaan_tubuh"
                            placeholder="Tanda Vital Tubuh">
                            {{ $antrian->asesmenperawat->keadaan_tubuh ?? null }}
                        </x-adminlte-textarea>
                    </div>
                </div>

            </form>
            <button type="submit" form="formPerawat" class="btn btn-success mb-1 w-100 withLoad">
                <i class="fas fa-edit"></i> Simpan & Tanda Tangan Pemeriksaan Perawat
            </button>
        </div>
    </div>
</div>
