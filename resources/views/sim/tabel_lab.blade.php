<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collLab">
        <h3 class="card-title">
            E-Laboratorium
        </h3>
    </a>
    <div id="collLab" class="collapse" role="tabpanel" aria-labelledby="headLab">
        <div class="card-body">
            <form action="{{ route('permintaanlab_simpan') }}" method="POST">
                @csrf
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan_id }}">
                <input type="hidden" name="kodekunjungan" value="{{ $antrian->kodekunjungan }}">
                <input type="hidden" name="kode" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="waktu" value="{{ now() }}">
                <input type="hidden" name="norm" value="{{ $antrian->kunjungan->norm }}">
                <input type="hidden" name="nama" value="{{ $antrian->kunjungan->nama }}">
                <div class="row">
                    <div class="col-md-3">
                        <u><b>HEMATOLOGI</b></u><br>
                        <b>RUTIN</b> <br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'HEMATOLOGI')->where('group', 'RUTIN') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                        <u><b>KLINIK URINE</b></u><br>
                        <b>URINE</b> <br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'KLINIK URINE')->where('group', 'URINE') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-3">
                        <u><b>KIMIA DARAH</b></u><br>
                        <b>KARBOHIDRAT</b> <br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'KIMIA DARAH')->where('group', 'KARBOHIDRAT') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                        <b>FAAL HATI</b> <br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'KIMIA DARAH')->where('group', 'FAAL HATI') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                        <b>FAAL GINJAL</b> <br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'KIMIA DARAH')->where('group', 'FAAL GINJAL') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                        <b>LEMAK</b> <br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'KIMIA DARAH')->where('group', 'LEMAK') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                        <b>FAAL JANTUNG</b> <br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'KIMIA DARAH')->where('group', 'FAAL JANTUNG') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                        <b>ELEKTROLIT DAN GAS DARAH</b><br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'KIMIA DARAH')->where('group', 'ELEKTROLIT DAN GAS DARAH') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-3">
                        <u><b>IMUNOSEROLOGI DAN SEROLOGI</b></u><br>
                        <b>HEPATITIS</b> <br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'IMUNOSEROLOGI & SEROLOGI')->where('group', 'HEPATITIS') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                        <b>PENANDA TUMOR</b> <br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'IMUNOSEROLOGI & SEROLOGI')->where('group', 'PENANDA TUMOR') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                        <b>HORMON</b> <br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'IMUNOSEROLOGI & SEROLOGI')->where('group', 'HORMON') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                        <b>RHEUMATIK & PROTEIN SPESIFIK</b> <br>
                        @foreach ($pemeriksaanlab->where('kelompok', 'IMUNOSEROLOGI & SEROLOGI')->where('group', 'RHEUMATIK & PROTEIN SPESIFIK') as $lab)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="{{ $lab->kode }}"
                                    name="permintaan_lab[]" value="{{ $lab->kode }}"
                                    @if ($antrian->permintaan_lab) @if (in_array($lab->kode, json_decode($antrian->permintaan_lab->permintaan_lab))) checked @endif
                                    @endif >
                                <label for="{{ $lab->kode }}"
                                    class="custom-control-label">{{ $lab->nama }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Catatan Permintaan Laboratorium"
                            name="catatan" placeholder="Catatan Permintaan Laboratorium">
                            {{ $antrian->permintaan_lab->catatan ?? null }}
                        </x-adminlte-textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-success"><i class="fas fa-diagnoses"></i> Submit Permintaan
                    Lab</button>
            </form>
        </div>
    </div>
</div>
