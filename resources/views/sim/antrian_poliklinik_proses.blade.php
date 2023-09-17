@extends('adminlte::page')
@section('title', 'Assesmen Dokter')
@section('content_header')
    <h1>Assesmen Dokter</h1>
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
            <a href="{{ route('antrianpoliklinik') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
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
                        <li class="nav-item"><a class="nav-link " href="#riwayattab" data-toggle="tab">Riwayat</a>
                        </li>
                        <li class="nav-item"><a class="nav-link " href="#labtab" data-toggle="tab">Laboratorium</a>
                        </li>
                        <li class="nav-item"><a class="nav-link " href="#radtab" data-toggle="tab">Radiologi</a>
                        </li>

                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="keperawatantab">
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
                                                <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem
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
                                                <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem
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
                        </div>
                        <div class="tab-pane" id="riwayattab">
                            Riwayat Kunjungan
                        </div>
                        <div class="tab-pane" id="riwayattab">
                            Laboratorium
                        </div>
                        <div class="tab-pane" id="riwayattab">
                            Radiologi
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#doktertab" data-toggle="tab">Dokter</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#resumetab" data-toggle="tab">Resume</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="doktertab">
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-select2 name="diagnosa1" label="Diagnosa Primer">
                                            <option>Option 1</option>
                                            <option disabled>Option 2</option>
                                            <option selected>Option 3</option>
                                        </x-adminlte-select2>
                                        <x-adminlte-select2 name="diagnosa2" label="Diagnosa Sekunder">
                                            <option>Option 1</option>
                                            <option disabled>Option 2</option>
                                            <option selected>Option 3</option>
                                        </x-adminlte-select2>
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan"
                                            name="riwayat_pengobatan" placeholder="Riwayat Pengobatan" />
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Rencana Perawatan"
                                            name="rencana_pengobatan" placeholder="Rencana Perawatan" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Instruksi Medis"
                                            name="instruksi_medis" placeholder="Instruksi Medis" />
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Tindakan Medis"
                                            name="tindakan_medis" placeholder="Tindakan Medis" />
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Resep Obat" name="resep_obat"
                                            placeholder="Resep Obat" />
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Catatan Resep"
                                            name="catatan_resep" placeholder="Catatan Resep" />
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Catatan Laboratorium"
                                            name="catatan_lab" placeholder="Catatan Laboratorium" />
                                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Catatan Radiologi"
                                            name="catatan_rad" placeholder="Catatan Radiologi" />
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success withLoad">
                                    <i class="fas fa-file-medical"></i> Simpan Assesmen Dokter
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane" id="resumetab">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="{{ asset('logo3.png') }}" alt="" width="100px">
                                        </td>
                                        <td>
                                            Rumah Sakit Umum Daerah <br>
                                            Waled Kabupaten Cirebon
                                        </td>
                                        <td>
                                            No RM : 00000000<br>
                                            Nama : Marwan Dhiaur Rahman<br>
                                            Tanggal Lahir : Cirebon 9 Mei 1998<br>
                                            Gender : L<br>
                                        </td>
                                    </tr>
                                    <tr class="table-warning text-center">
                                        <td colspan="3">
                                            <b>
                                                FORMULIR ASSESMENT DOKTER
                                            </b>
                                        </td>
                                    </tr>
                                    <tr style="font-size: 10">
                                        <td colspan="2" width="50%" scope="row">
                                            {{-- <u><b>ANAMNESA</b></u> --}}
                                            <dl>
                                                <dt>Diagnosis Primer :</dt>
                                                <dd>A description list is perfect for defining terms.</dd>
                                                <dt>Diagnosis Sekunder :</dt>
                                                <dd>A description list is perfect for defining terms.</dd>
                                                <dt>Riwayat Pengobatan :</dt>
                                                <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                                                <dt>Rencana Perawatan :</dt>
                                                <dd>A description list is perfect for defining terms.</dd>


                                            </dl>
                                        </td>
                                        <td width="50%">
                                            <u><b>TERAPI</b></u>
                                            <dl>
                                                <dt>Tindakan :</dt>
                                                <dd>A description list is perfect for defining terms.</dd>
                                                <dt>Instruksi Medik dan Keperawatan :</dt>
                                                <dd>A description list is perfect for defining terms.</dd>
                                                <dt>Resep Obat</dt>
                                                <dd>A description list is perfect for defining terms.</dd>
                                                <dt>Catatan Resep Obat</dt>
                                                <dd>A description list is perfect for defining terms.</dd>
                                            </dl>
                                        </td>
                                    </tr>
                                    <tr style="font-size: 10">
                                        <td colspan="2" width="50%" scope="row">
                                            <u><b>PEMERIKSAAN PENUNJANG</b></u>
                                            <dl>
                                                <dt>Laboratorium :</dt>
                                                <dd>A description list is perfect for defining terms.</dd>
                                                <dt>Radiologi :</dt>
                                                <dd>A description list is perfect for defining terms.</dd>
                                            </dl>
                                        </td>
                                        <td width="50%">
                                            <u><b>CATATAN</b></u>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <a href="{{ route('lanjutpoliklinik') }}?kodebooking={{ $antrian->kodebooking }}"
                                class="btn btn-warning withLoad">
                                <i class="fas fa-user-plus"></i> Lanjut Pemeriksaan Dokter
                            </a>
                            <a href="{{ route('batalantrian') }}?kodebooking={{ $antrian->kodebooking }}&keterangan=Dibatalkan dipendaftaran {{ Auth::user()->name }}"
                                class="btn btn-danger withLoad">
                                <i class="fas fa-times"></i> Batal
                            </a>
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
