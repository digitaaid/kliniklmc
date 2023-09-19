@extends('vendor.medico.master')
@section('title', 'Antrian Pasien')
@section('content')
    <!-- ======= Appointment Section ======= -->
    <br><br><br><br>
    <section id="appointment" class="appointment section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Surat Kontrol Pasien</h2>
                <p>
                    Hemat waktu dan nikmati kemudahan dengan pendaftaran online di Klinik Hematologi Onkologi kami. Dengan
                    mengisi formulir sederhana di bawah ini, Anda dapat membuat janji dengan cepat dan praktis.
                </p>
            </div>
            <form action="" id="formCekAntrian" method="GET" role="form">
                <label for="noSuratKontrol">Nomor Surat Kontrol</label>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="noSuratKontrol" id="noSuratKontrol"
                        placeholder="Nomor Surat Kontrol" value="{{ $request->noSuratKontrol }}" required>
                </div>
                <div class="col text-center">
                    <button type="submit" class="btn btn-warning preloader" form="formCekAntrian">Cek Kodebooking</button>
                </div>
            </form>
            @if ($request->error)
                <div class="alert alert-danger mt-3">
                    <h5>
                        <i class="icon fas fa-ban"></i>
                        Ops Terjadi Masalah !
                    </h5>
                    <p>{{ $request->error }}</p>
                </div>
            @endif
            @if ($request->success)
                <div class="alert alert-success mt-3">
                    <h5>
                        <i class="icon fas fa-check"></i>
                        Berhasil
                    </h5>
                    <p>{{ $request->success }}</p>
                </div>
            @endif

        </div>
        @isset($suratkontrol)
            <div class="container" data-aos="fade-up">
                <div class="row mt-3">
                    <div class="row ">
                        <div class="col-md-12 ">
                            <div class="card">
                                <h5 class="card-header">Surat Kontrol Pasien BPJS</h5>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-3">No Surat Kontrol</dt>
                                        <dd class="col-sm-9">{{ $suratkontrol->noSuratKontrol }}</dd>
                                        <dt class="col-sm-3">jnsKontrol</dt>
                                        <dd class="col-sm-9">{{ $suratkontrol->sep->peserta->nama }}</dd>
                                        <dt class="col-sm-3">noKartu</dt>
                                        <dd class="col-sm-9">{{ $suratkontrol->sep->peserta->noKartu }}</dd>
                                        <dt class="col-sm-3">kelamin</dt>
                                        <dd class="col-sm-9">{{ $suratkontrol->sep->peserta->kelamin }}</dd>
                                        <br><br>
                                        <dt class="col-sm-3">tglRencanaKontrol</dt>
                                        <dd class="col-sm-9">
                                            <form action="{{ route('suratkontrol_update_web') }}" method="POST" id="updateSK">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="noSuratKontrol"
                                                    value="{{ $suratkontrol->noSuratKontrol }}">
                                                <input type="hidden" name="noSEP" value="{{ $suratkontrol->sep->noSep }}">
                                                <input type="hidden" name="kodeDokter"
                                                    value="{{ $suratkontrol->kodeDokter }}">
                                                <input type="hidden" name="poliKontrol"
                                                    value="{{ $suratkontrol->poliTujuan }}">
                                                <input type="hidden" name="user"
                                                    value="{{ $suratkontrol->sep->peserta->nama }}P">
                                                <input type="hidden" name="tglKontrolSebelumnya"
                                                    value="{{ $suratkontrol->tglRencanaKontrol }}">
                                                <div class="form-group">
                                                    <input id="tglRencanaKontrol" name="tglRencanaKontrol"
                                                        class="single-input datepicker form-control mb-3"
                                                        placeholder="Pick date" value="{{ $suratkontrol->tglRencanaKontrol }}">
                                                </div>
                                            </form>
                                        </dd>
                                        <dt class="col-sm-3">namaJnsKontrol</dt>
                                        <dd class="col-sm-9">{{ $suratkontrol->namaJnsKontrol }}</dd>
                                        <dt class="col-sm-3">namaPoliTujuan</dt>
                                        <dd class="col-sm-9">{{ $suratkontrol->namaPoliTujuan }}</dd>
                                        <dt class="col-sm-3">namaDokter</dt>
                                        <dd class="col-sm-9">{{ $suratkontrol->namaDokter }}</dd>
                                        <br><br>
                                        <dt class="col-sm-3">noSep</dt>
                                        <dd class="col-sm-9">{{ $suratkontrol->sep->noSep }}</dd>
                                        <dt class="col-sm-3">jnsPelayanan</dt>
                                        <dd class="col-sm-9">{{ $suratkontrol->sep->jnsPelayanan }}</dd>
                                        <dt class="col-sm-3">poli</dt>
                                        <dd class="col-sm-9">{{ $suratkontrol->sep->poli }}</dd>
                                        <dt class="col-sm-3">diagnosa</dt>
                                        <dd class="col-sm-9">{{ $suratkontrol->sep->diagnosa }}</dd>
                                    </dl>

                                </div>
                                <div class="card-footer text-muted">
                                    <button type="submit" class="btn btn-danger preloader" form="updateSK">Ubah Tanggal
                                        Kontrol</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </section>
@endsection
