@extends('vendor.medico.master')
@section('title', 'Antrian Pasien')
@section('content')
    <!-- ======= Appointment Section ======= -->
    <br><br><br><br>
    <section id="appointment" class="appointment section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Antrian Pasien</h2>
                <p>
                    Hemat waktu dan nikmati kemudahan dengan pendaftaran online di Klinik Hematologi Onkologi kami. Dengan
                    mengisi formulir sederhana di bawah ini, Anda dapat membuat janji dengan cepat dan praktis.
                </p>
            </div>
            <form action="" id="formDaftar" method="GET" role="form">
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="kodebooking" id="kodebooking" placeholder="Kodebooking"
                        value="{{ $request->kodebooking }}" required>
                </div>
                <div class="col text-center">
                    <button type="submit" class="btn btn-warning preloader" form="formDaftar">Cek Kodebooking</button>
                </div>
            </form>
        </div>
        <div class="container" data-aos="fade-up">
            @if ($request->error)
                <div class="alert alert-danger mt-3">
                    <h5>
                        <i class="icon fas fa-ban"></i>
                        Ops Terjadi Masalah !
                    </h5>
                    <p>{{ $request->error }}</p>
                </div>
            @endif
            @isset($antrian)
                <div class="alert alert-warning mt-3" role="alert">
                    <b>Antrian Berhasil Ditermukan.</b> Silahkan screenshot QR Code Antrian untuk memudahkan saat checkin di
                    Anjungan.
                </div>
            @endisset
        </div>
        @isset($antrian)
            <div class="container" data-aos="fade-up">
                <div class="row mt-3">
                    <div class="row ">
                        <div class="col-md-6 ">
                            <div class="card">
                                <h5 class="card-header">Antrian Pasien</h5>
                                <div class="card-body">
                                    <div>
                                        {!! QrCode::size(200)->generate($antrian->kodebooking) !!} <br><br>
                                    </div>
                                    <dl>
                                        <dt>Kodebooking</dt>
                                        <dd>{{ $antrian->kodebooking }}</dd>
                                        <dt>Nomor Antrian</dt>
                                        <dd>{{ $antrian->nomorantrean }} / {{ $antrian->angkaantrean }} </dd>
                                        <dt>Nama Pasien</dt>
                                        <dd>{{ $antrian->nama }}</dd>
                                        <dt>Poliklinik</dt>
                                        <dd>{{ $antrian->namapoli }}</dd>
                                        <dt>Dokter</dt>
                                        <dd>{{ $antrian->namadokter }}</dd>
                                        <dt>Sisa Antrian</dt>
                                        <dd>{{ $res->response->sisaantrean }}</dd>
                                        <dt>Antrian Sedang Dipanggil</dt>
                                        <dd>{{ $res->response->antreanpanggil }}</dd>
                                        <dt>Keterangan</dt>
                                        <dd>{{ $antrian->keterangan }}</dd>
                                    </dl>
                                </div>
                                <div class="card-footer text-muted">
                                    <a href="#" class="btn btn-danger">Batalkan Antrian</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>

                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endisset

    </section>
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
