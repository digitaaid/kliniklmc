@extends('adminlte::page')
@section('title', 'Antrian Perawat')
@section('content_header')
    <h1>Antrian Perawat</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('sim.antrian_profil')
        </div>
        <div class="col-md-9">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <a href="{{ route('antrianperawat') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
                class="btn btn-danger mb-2 mr-1 withLoad">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div class="btn btn-secondary mb-2 mr-1">
                <i class="fas fa-info-circle"></i>
                Status Antrian :
                @switch($antrian->taskid)
                    @case(0)
                        Belum Checkin
                    @break

                    @case(1)
                        Tunggu Pendaftaran
                    @break

                    @case(2)
                        Proses Pendaftaran
                    @break

                    @case(3)
                        Tunggu Poliklinik
                    @break

                    @case(4)
                        Pemeriksaan Dokter
                    @break

                    @case(5)
                        Tunggu Farmasi
                    @break

                    @case(6)
                        Proses Farmasi
                    @break

                    @case(7)
                        Selesai Pelayanan
                    @break

                    @case(99)
                        Batal
                    @break

                    @default
                @endswitch
            </div>
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#keperawatantab"
                                data-toggle="tab">Keperawatan</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#resumetab" data-toggle="tab">Resume</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="keperawatantab">
                            <form action="{{ route('editasesmenperawat') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                                <input type="hidden" name="kodekunjungan" value="{{ $antrian->kunjungan->kode ?? null }}">
                                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id ?? null }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Keluhan Utama"
                                            name="keluhan_utama" placeholder="Keluhan Utama" />
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Penyakit"
                                            name="riwayat_penyakit" placeholder="Riwayat Penyakit" />
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Alergi"
                                            name="riwayat_alergi" placeholder="Riwayat Alergi" />
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan"
                                            name="riwayat_pengobatan" placeholder="Riwayat Pengobatan" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <x-adminlte-input name="denyut_jantung" fgroup-class="col-md-6"
                                                label="Denyut Jantung" igroup-size="sm" placeholder="Denyut Jantung" />
                                            <x-adminlte-input name="pernapasan" fgroup-class="col-md-6" label="Pernapasan"
                                                igroup-size="sm" placeholder="Pernapasan" />
                                            <x-adminlte-input name="sistole" fgroup-class="col-md-6" label="Sistole"
                                                igroup-size="sm" placeholder="Sistole" />
                                            <x-adminlte-input name="distole" fgroup-class="col-md-6" label="Distole"
                                                igroup-size="sm" placeholder="Distole" />
                                            <x-adminlte-input name="suhu" fgroup-class="col-md-6" label="Suhu Tubuh"
                                                igroup-size="sm" placeholder="Suhu Tubuh" />
                                            <x-adminlte-input name="berat_badan" fgroup-class="col-md-6" label="Berat Batan"
                                                igroup-size="sm" placeholder="Berat Batan" />
                                            <x-adminlte-input name="tinggi_badan" fgroup-class="col-md-6"
                                                label="Tinggi Badan" igroup-size="sm" placeholder="Tinggi Badan" />
                                            <x-adminlte-input name="bsa" fgroup-class="col-md-6"
                                                label="Index BSA" igroup-size="sm" placeholder="Index BSA" />
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran1"
                                                    name="customRadio">
                                                <label for="kesadaran1" class="custom-control-label">Sadar baik</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran2"
                                                    name="customRadio">
                                                <label for="kesadaran2" class="custom-control-label">Berespon dengan
                                                    kata-kata</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran3"
                                                    name="customRadio">
                                                <label for="kesadaran3" class="custom-control-label">Hanya berespons jika
                                                    dirangsang nyeri/pain</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran4"
                                                    name="customRadio">
                                                <label for="kesadaran4" class="custom-control-label">Pasien tidak
                                                    sadar/unresponsive </label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran5"
                                                    name="customRadio">
                                                <label for="kesadaran5" class="custom-control-label">Gelisah /
                                                    bingung</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran6"
                                                    name="customRadio">
                                                <label for="kesadaran6" class="custom-control-label">Acute Confusional
                                                    State</label>
                                            </div>
                                        </div>
                                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Tanda Vital Keadaan Tubuh"
                                            name="keadaan_tubuh" placeholder="Tanda Vital Fisik" />
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Status Psikologi"
                                            name="status_psikologi" placeholder="Status Psikologi" />
                                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Status Sosial"
                                            name="status_sosial" placeholder="Status Sosial" />
                                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Status Spiritual"
                                            name="status_spiritual" placeholder="Status Spiritual" />
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success withLoad">
                                    <i class="fas fa-file-medical"></i> Simpan Assesmen Keperawatan
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane" id="resumetab">
                            @if ($kunjungan->asesmenperawat)
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th scope="col">
                                                <img src="{{ asset('medicio/assets/img/lmc.png') }}" alt=""
                                                    height="75px">
                                            </th>
                                            <th scope="col">
                                                Rumah Sakit Umum Daerah <br>
                                                Waled Kabupaten Cirebon
                                            </th>
                                            <th scope="col">
                                                No RM : 00000000<br>
                                                Nama : Marwan Dhiaur Rahman<br>
                                                Tanggal Lahir : Cirebon 9 Mei 1998<br>
                                                Gender : L<br>
                                            </th>
                                        </tr>
                                        <tr class="table-warning text-center">
                                            <td colspan="3">
                                                <b>
                                                    FORMULIR UMUM / ASSESMENT RAWAT JALAN
                                                </b>
                                            </td>
                                        </tr>
                                        <tr style="font-size: 10">
                                            <td colspan="2" width="50%" scope="row">
                                                <u><b>ANAMNESA</b></u>
                                                <dl>
                                                    <dt>Keluhan Utama :</dt>
                                                    <dd>A description list is perfect for defining terms.</dd>
                                                    <dt>Riwayat Penyakit :</dt>
                                                    <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio
                                                        sem
                                                        nec elit.</dd>
                                                    <dt>Riwayat Alergi :</dt>
                                                    <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                                                    <dt>Riwayat Pengobatan :</dt>
                                                    <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                                                </dl>
                                            </td>
                                            <td width="50%">
                                                <u><b>PEMERIKSAAN FISIK</b></u>
                                                <br>
                                                <b>Denyut Jantung : </b> 30 spm <br>
                                                <b>Pernapasan : </b> 30 spm <br>
                                                <b>Tekanan Darah : </b> 30 spm <br>
                                                <b>Suhu Tubuh : </b> 30 spm <br><br>
                                                <dl>
                                                    <dt>Tingkat Kesadaran :</dt>
                                                    <dd>A description list is perfect for defining terms.</dd>
                                                    <dt>Tanda Vital Tubuh</dt>
                                                    <dd>A description list is perfect for defining terms.</dd>
                                                </dl>
                                            </td>
                                        </tr>
                                        <tr style="font-size: 10">
                                            <td colspan="2" width="50%" scope="row">
                                                <u><b>PEMERIKSAAN PSIKOLOGI</b></u>
                                                <dl>
                                                    <dt>Kondisi Psikologis :</dt>
                                                    <dd>A description list is perfect for defining terms.</dd>
                                                    <dt>Kondisi Sosial Ekonomi :</dt>
                                                    <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio
                                                        sem
                                                        nec elit.</dd>
                                                    <dt>Kondisi Spiritual :</dt>
                                                    <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                                                </dl>
                                            </td>
                                            <td width="50%">
                                                <u><b>CATATAN</b></u>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <x-adminlte-alert title="Belum dilakukan asesmen perawat" theme="danger">
                                    Silahkan lakukan asesmen keperawatan
                                </x-adminlte-alert>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('js')

@endsection
