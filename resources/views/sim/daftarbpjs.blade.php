@extends('vendor.medico.master')
@section('title', 'Daftar Antrian BPJS')
@section('content')
    <!-- ======= Appointment Section ======= -->
    <br><br><br><br>
    <section id="appointment" class="appointment section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Daftar Antrian BPJS</h2>
                <p>
                    Hemat waktu dan nikmati kemudahan dengan pendaftaran online di Klinik Hematologi Onkologi kami. Dengan
                    mengisi formulir sederhana di bawah ini, Anda dapat membuat janji dengan cepat dan praktis.
                </p>
            </div>
            @if ($request->error)
                <div class="alert alert-danger">
                    <h5>
                        <i class="icon fas fa-ban"></i>
                        Ops Terjadi Masalah !
                    </h5>
                    <p>{{ $request->error }}</p>
                </div>
            @endif
            @if ($request->warning)
                <div class="alert alert-warning">
                    <h5>
                        <i class="icon fas fa-ban"></i>
                        Ops Terjadi Masalah !
                    </h5>
                    <p>{{ $request->warning }}</p>
                </div>
            @endif
            <form action="{{ route('prosesdaftarbpjs') }}" id="formDaftar" method="POST" role="form" data-aos="fade-up"
                data-aos-delay="100">
                @csrf
                <div class="form-group mb-3">
                    <label for="nomorkartu"><b>No Kartu BPJS : </b></label>
                    <input type="text" class="form-control" name="nomorkartu" id="nomorkartu"
                        placeholder="Nomor Kartu BPJS" value="{{ $request->nomorkartu }}"
                        {{ $request->nik ? 'readonly' : null }}>
                </div>
                <div class="form-group mb-3">
                    <label for="nohp"><b>No HP / Whatsapp : </b></label>
                    <input type="text" class="form-control" name="nohp" id="nohp" placeholder="Nomor HP"
                        value="{{ $request->nohp }}">
                </div>
                @if ($request->nik && $request->nohp)
                    <div class="form-group mb-3">
                        <label for="nik"><b>NIK : </b></label>
                        <input type="text" class="form-control" name="nik" id="nik" placeholder="NIK"
                            value="{{ $request->nik }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nama"><b>Nama : </b></label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama"
                            value="{{ $request->nama }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="norm"><b>No Rekam Medis : </b></label>
                        <input type="text" class="form-control" name="norm" id="norm" placeholder="Nomor RM"
                            value="{{ $request->norm }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tanggalperiksa"><b>Tanggal Periksa : </b></label>
                        <input type="text" class="form-control datepicker" name="tanggalperiksa" id="tanggalperiksa"
                            placeholder="Tanggal Periksa" value="{{ $request->tanggalperiksa }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="jeniskunjungan"><b>Jenis Kunjungan : </b></label>
                        <select name="jeniskunjungan" id="jeniskunjungan" class="form-select">
                            <option selected disabled>Pilih Jenis Kunjungan</option>
                            <option value="1" {{ $request->jeniskunjungan == '1' ? 'selected' : null }}>Rujukan FKTP
                            </option>
                            <option value="3" {{ $request->jeniskunjungan == '3' ? 'selected' : null }}>Kontrol
                            </option>
                            <option value="4" {{ $request->jeniskunjungan == '4' ? 'selected' : null }}>Rujukan Antar
                                RS</option>
                        </select>
                    </div>
                @endif
                @if ($request->tanggalperiksa && $jadwals->count() && $request->jeniskunjungan)
                    @if ($rujukans || $suratkontrols)
                        <div class="form-group mb-3">
                            <label for="jadwal"><b>Jadwal Dokter : </b></label>
                            <select name="jadwal" id="jadwal" class="form-select" required>
                                <option selected disabled>Pilih Jadwal Dokter</option>
                                @foreach ($jadwals as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $request->jadwal ? 'selected' : null }}>
                                        {{ $item->jadwal }} {{ $item->namasubspesialis }}
                                        {{ $item->namadokter }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jadwal"><b>No Rujukan / Surat Kontrol : </b></label>
                            <select name="nomorreferensi" id="nomorreferensi" class="form-select" required>
                                <option selected disabled>Pilih Nomor Referensi</option>
                                @isset($suratkontrols)
                                    @foreach ($suratkontrols as $item)
                                        <option value="{{ $item->noSuratKontrol }}"> {{ $item->noSuratKontrol }} TGL
                                            {{ $item->tglRencanaKontrol }}</option>
                                    @endforeach
                                @endisset
                                @isset($rujukans)
                                    @foreach ($rujukans as $rujukan)
                                        <option value="{{ $rujukan->noKunjungan }}">{{ $rujukan->noKunjungan }}
                                            {{ $rujukan->poliRujukan->nama }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                    @endif
                @endif
                <div class="col text-center">
                    @empty($request->error)
                        <button type="submit" class="btn btn-warning preloader"
                            form="formDaftar">{{ $request->button }}</button>
                    @endempty
                    <a href="{{ route('daftar') }}" class="btn btn-danger">
                        <i class="icon fas fa-sync"></i>
                        Daftar Ulang
                    </a>

                </div>
            </form>
        </div>
    </section><!-- End Appointment Section -->
    @include('vendor.medico.content.contact')
@endsection

@section('js')
    <script>
        $(function() {
            $('#btnAntrian').click(function() {
                alert('asd');
            });
        });
    </script>
@endsection
