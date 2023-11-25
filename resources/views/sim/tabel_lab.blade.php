<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collLab">
        <h3 class="card-title">
            E-Laboratorium
        </h3>
        <div class="card-tools">
            @if ($permintaanlab)
                {{ count(json_decode($permintaanlab->permintaan_lab)) }}
            @endif Pemeriksaan
            <i class="fas fa-info-circle"></i>
        </div>
    </a>
    <div id="collLab" class="collapse" role="tabpanel" aria-labelledby="headLab">
        <div class="card-body">
            <x-adminlte-card title="Permintaan Laboratorium" header-class="p-2" theme="secondary"
                collapsible="{{ $hasillab ? 'collapsed' : null }}">
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
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
                                        @if ($permintaanlab) @if (in_array($lab->kode, json_decode($permintaanlab->permintaan_lab))) checked @endif
                                        @endif >
                                    <label for="{{ $lab->kode }}"
                                        class="custom-control-label">{{ $lab->nama }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-textarea igroup-size="sm" rows=4 label="Catatan Permintaan Laboratorium"
                                name="catatan" placeholder="Catatan Permintaan Laboratorium">
                                {{ $permintaanlab->catatan ?? null }}
                            </x-adminlte-textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-diagnoses"></i> Submit Permintaan
                        Lab</button>
                </form>
            </x-adminlte-card>
            @if ($hasillab)
            <x-adminlte-card title="Hasil Pemeriksaan Laboratorium" header-class="p-2" theme="secondary" collapsible>
                <div class="row invoice-info">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4 m-0">Nama</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaanlab->nama }} </dd>
                            <dt class="col-sm-4 m-0">No RM</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaanlab->norm }} </dd>
                            <dt class="col-sm-4 m-0">Tgl. Lahir</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaanlab->pasien->tgl_lahir ?? '-' }} </dd>
                            <dt class="col-sm-4 m-0">Jenis Kelamin</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaanlab->pasien->gender ?? '-' }} </dd>
                            <dt class="col-sm-4 m-0">Diagnosa</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaanlab->diagnosa }} </dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4 m-0">Dokter</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaanlab->dpjp }} </dd>
                            <dt class="col-sm-4 m-0">Alamat</dt>
                            <dd class="col-sm-8 m-0">: Klinik LMC </dd>
                            <dt class="col-sm-4 m-0">Tgl Pemeriksaan</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaanlab->waktu }} </dd>
                        </dl>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-sm  table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Pemeriksaan</th>
                                    <th colspan="2">Hasil</th>
                                    <th>Nilai Rujukan</th>
                                    <th>Satuan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $key = 0;
                                @endphp
                                @foreach ($pemeriksaanlab->whereIn('kode', json_decode($permintaanlab->permintaan_lab)) as $prksa)
                                    <tr>
                                        <td><b>{{ $prksa->nama }}</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($prksa->parameters as $param)
                                        <tr>
                                            <input type="hidden" name="parameter_id[]" value="{{ $param->id }}">
                                            <td>&emsp;&emsp;{{ $param->nama }}</td>
                                            <td>{{ $hasillab->hasil[$key] ?? '-' }}</td>
                                            <th>*&emsp;&emsp;</th>
                                            <td>{{ $param->nilai_rujukan }}</td>
                                            <td>{{ $param->satuan }}</td>
                                            <td>{{ $hasillab->keterangan[$key] ?? '-' }}
                                            </td>
                                        </tr>
                                        @php
                                            $key++;
                                        @endphp
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-8 mt-1">
                        <dl>
                            <dt>Catatan :</dt>
                            <dd>{{ $permintaanlab->catatan }} </dd>
                        </dl>
                    </div>
                    <div class="col-sm-2 mt-1">
                        <b>Pemeriksa,</b>
                        <br><br><br>
                        <hr>
                    </div>
                </div>
            </x-adminlte-card>
            @endif

        </div>
    </div>
</div>
