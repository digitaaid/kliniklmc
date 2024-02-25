<x-adminlte-modal id="modalSBAR" title="SBAR & TBAK" size="xl" icon="fas fa-hand-holding-medical" theme="success"
    static-backdrop>
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-input name="pengirim" label="Pengirim" placeholder="Pengirim" fgroup-class="row"
                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                value="{{ Auth::user()->name }}" />
            <x-adminlte-input name="no_pengirim" label="No Pengirim" placeholder="No Whatsapp Pengirim"
                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                enable-old-support value="{{ Auth::user()->phone }}" />
            <x-adminlte-textarea name="situation" label="Situation (S)" placeholder="Situation" fgroup-class="row"
                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" rows="13" enable-old-support
                required>
                Salam dok, saya {{ Auth::user()->name }} dari keperawatan Klinik LMC izin melaporkan pasien dengan data sbb:
Nama : {{ $antrian->nama }}
Umur : {{ \Carbon\Carbon::parse($antrian->kunjungan->tgl_masuk)->diffInYears($antrian->kunjungan->tgl_lahir) }} tahun, No RM : {{ $antrian->norm }}
Diagnosa Masuk :
Keluhan Utama :
            </x-adminlte-textarea>
            <x-adminlte-textarea name="background" label="Background (B)" placeholder="Background" fgroup-class="row"
                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" rows="5" enable-old-support
                required>
                Riwayat Penyakit :
                Alergi :
                Riwayat Pengobatan :
            </x-adminlte-textarea>
            <x-adminlte-textarea name="assessment" label="Assessment (A)" placeholder="Assessment" rows="10"
                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                enable-old-support required>
                Kesadaran :
                Nadi :
                RR :
                Suhu :
                Detak Jantung :
                TFU :
                TFU :
            </x-adminlte-textarea>
            <x-adminlte-textarea name="recomendation" label="Recomendation (R)" placeholder="Recomendation"
                rows="5" fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                enable-old-support required>
                Tindakan Sudah Dilakukan :
                Instruksi Dokter :
            </x-adminlte-textarea>
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <x-adminlte-input-date name="waktu_sbar" label="Waktu SBAR" fgroup-class="row"
                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" value="{{ now() }}"
                placeholder="Waktu SBAR" :config="$config">
            </x-adminlte-input-date>
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="penerima" label="Penerima" placeholder="Penerima" fgroup-class="row"
                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                value="{{ $antrian->kunjungan->dokters->namadokter }}" />
            <x-adminlte-input name="no_penerima" label="No Penerima" placeholder="No Whatsapp Penerima"
                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                enable-old-support />
            <x-adminlte-textarea name="tulis" label="Tulis (T)" placeholder="Tulis" rows="5" fgroup-class="row"
                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support required>
            </x-adminlte-textarea>
            <x-adminlte-textarea name="baca" label="Baca (BA)" placeholder="Baca" rows="5" fgroup-class="row"
                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support required>
            </x-adminlte-textarea>
            <x-adminlte-textarea name="konfirmasi" label="Konfirmasi (K)" placeholder="Konfirmasi" rows="5"
                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                enable-old-support required>
            </x-adminlte-textarea>
            <x-adminlte-input-date name="waktu_tbak" label="Waktu TBAK" fgroup-class="row"
                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" placeholder="Waktu TBAK"
                :config="$config">
            </x-adminlte-input-date>
        </div>
    </div>
</x-adminlte-modal>
