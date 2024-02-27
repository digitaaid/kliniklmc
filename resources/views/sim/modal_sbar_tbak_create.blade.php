<x-adminlte-modal id="modalSBAR" title="SBAR & TBAK" size="xl" icon="fas fa-hand-holding-medical" theme="success">
    <form action="{{ route('sbartbak.store') }}" name="formSBARTBAK" id="formSBARTBAK" method="POST">
        @csrf
        <div class="row">
            <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
            <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
            <input type="hidden" name="kodekunjungan" value="{{ $antrian->kunjungan->kode ?? '-' }}">
            <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id ?? '-' }}">
            <div class="col-md-6">
                <x-adminlte-input name="pengirim" label="Pengirim" placeholder="Pengirim" fgroup-class="row"
                    label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                    value="{{  $antrian->sbar?  $antrian->sbar->pengirim ? $antrian->sbar->pengirim :  Auth::user()->name :null}}" />
                <x-adminlte-input name="no_pengirim" label="No Pengirim" placeholder="No Whatsapp Pengirim"
                    fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                    enable-old-support value="{{  $antrian->sbar?  $antrian->sbar->no_pengirim ? $antrian->sbar->no_pengirim :  Auth::user()->phone :null  }}" />
                <x-adminlte-textarea name="situation" label="Situation (S)" placeholder="Situation" fgroup-class="row"
                    label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" rows="13"
                    enable-old-support required>
@if ($antrian->sbar)
    {{ $antrian->sbar->situation }}
@else
Salam dok, saya {{ Auth::user()->name }} dari keperawatan Klinik LMC izin melaporkan pasien dengan data sbb:
Nama : {{ $antrian->nama }}
Umur : {{ \Carbon\Carbon::parse($antrian->kunjungan->tgl_masuk)->diffInYears($antrian->kunjungan->tgl_lahir) }} tahun, No RM : {{ $antrian->norm }}
Keluhan Utama : {{ $antrian->asesmenperawat->keluhan_utama ?? '-' }}
Diagnosa Masuk : {{ $antrian->asesmenperawat->diagnosa_keperawatan ?? '-' }}
@endif
                </x-adminlte-textarea>
                <x-adminlte-textarea name="background" label="Background (B)" placeholder="Background"
                    fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                    rows="5" enable-old-support required>
@if ($antrian->sbar)
{{ $antrian->sbar->background }}
@else
Riwayat Penyakit : {{ $antrian->asesmenperawat->riwayat_penyakit ?? '-' }}
Riwayat Penyakit Keluarga : {{ $antrian->asesmenperawat->riwayat_penyakit_keluarga ?? '-' }}
Riwayat Alergi : {{ $antrian->asesmenperawat->riwayat_alergi ?? '-' }}
Riwayat Pengobatan : {{ $antrian->asesmenperawat->riwayat_pengobatan ?? '-' }}
@endif

                </x-adminlte-textarea>
                <x-adminlte-textarea name="assessment" label="Assessment (A)" placeholder="Assessment" rows="10"
                    fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                    enable-old-support required>
@if ($antrian->sbar)
{{ $antrian->sbar->assessment }}
@else
Detak Jantung : {{ $antrian->asesmenperawat->denyut_jantung ?? '-' }} spm , RR : {{ $antrian->asesmenperawat->pernapasan ?? '-' }} spm
Tekanan Darah : {{ $antrian->asesmenperawat->sistole ?? '-' }}/{{ $antrian->asesmenperawat->distole ?? '-' }} mmHg , Suhu : {{ $antrian->asesmenperawat->suhu ?? '-' }} celcius
TT : {{ $antrian->asesmenperawat->tinggi_badan ?? '-' }} cm , BT : {{ $antrian->asesmenperawat->berat_badan ?? '-' }} kg
Kesadaran : {{ $antrian->asesmenperawat->tingkat_kesadaran ?? '-' }}
Tanda Vital Tubuh : {{ $antrian->asesmenperawat->keadaan_tubuh ?? '-' }}
@endif
                </x-adminlte-textarea>
                <x-adminlte-textarea name="recomendation" label="Recomendation (R)" placeholder="Recomendation"
                    rows="5" fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                    igroup-class="col-9" enable-old-support required>
@if ($antrian->sbar)
{{ $antrian->sbar->recomendation }}
@else
Rencana Keperawatan : {{ $antrian->asesmenperawat->rencana_keperawatan ?? '-' }}
Tindakan Keperawatan : {{ $antrian->asesmenperawat->tindakan_keperawatan ?? '-' }}
Evaluasi Keperawatan : {{ $antrian->asesmenperawat->evaluasi_keperawatan ?? '-' }}
@endif
                </x-adminlte-textarea>
                @php
                    $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                @endphp
                <x-adminlte-input-date name="waktu_sbar" label="Waktu SBAR" fgroup-class="row"
                    label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                    value="{{ $antrian->sbar->waktu_sbar ?? now() }}" placeholder="Waktu SBAR" :config="$config">
                </x-adminlte-input-date>
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="penerima" label="Penerima" placeholder="Penerima" fgroup-class="row"
                    label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                    value="{{ $antrian->kunjungan->dokters->namadokter }}" required />
                <x-adminlte-input name="no_penerima" label="No Penerima" placeholder="No Whatsapp Penerima"
                    fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                    enable-old-support required value="{{  $antrian->sbar?  $antrian->sbar->no_penerima ? $antrian->sbar->no_penerima :  '089529909036':null  }} " />
                <x-adminlte-textarea name="tulis" label="Tulis (T)" placeholder="Tulis" rows="5"
                    fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                    enable-old-support>
@if ($antrian->sbar)
{{ $antrian->sbar->tulis }}
@else
Terimakasih atas informasi pasiennya
@endif
                </x-adminlte-textarea>
                <x-adminlte-textarea name="baca" label="Baca (BA)" placeholder="Baca" rows="5"
                    fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                    enable-old-support>
@if ($antrian->sbar)
{{ $antrian->sbar->baca }}
@else
Lakukan pemeriksaan
@endif

                </x-adminlte-textarea>
                <x-adminlte-textarea name="konfirmasi" label="Konfirmasi (K)" placeholder="Konfirmasi"
                    rows="5" fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                    igroup-class="col-9" enable-old-support>
@if ($antrian->sbar)
{{ $antrian->sbar->konfirmasi }}
@else
Baik, Akan melakukan pemeriksaan sesuai jadwal
@endif
                </x-adminlte-textarea>
                <x-adminlte-input-date name="waktu_tbak" label="Waktu TBAK" fgroup-class="row"
                    label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" placeholder="Waktu TBAK"
                    :config="$config" value="{{ $antrian->sbar->waktu_tbak ?? now() }}">
                </x-adminlte-input-date>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <button type="submit" form="formSBARTBAK" class="btn btn-success">
            <i class="fas fa-save"></i> Simpan
        </button>
        <a href="{{ route('print_sbar_tbak') }}?kodekunjungan={{ $antrian->kunjungan->kode }}"
            class="btn btn-warning ml-auto" target="_blank"> <i class="fas fa-print"></i> Print</a>
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
