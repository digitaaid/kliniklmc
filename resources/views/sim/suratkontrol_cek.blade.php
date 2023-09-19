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
                    <input type="text" class="form-control" name="noSuratKontrol" id="noSuratKontrol" placeholder="Nomor Surat Kontrol"
                        value="{{ $request->noSuratKontrol }}" required>
                </div>
                <div class="col text-center">
                    <button type="submit" class="btn btn-warning preloader" form="formCekAntrian">Cek Kodebooking</button>
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
                        <div class="col-md-12 ">
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
                                        <dt>Antrian Sedang Dipanggil</dt>
                                        <dd>{{ $res->response->antreanpanggil }}</dd>
                                        <dt>Status</dt>
                                        <dd>
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
                                        </dd>
                                        <dt>Keterangan</dt>
                                        <dd>{{ $antrian->keterangan }}</dd>
                                    </dl>
                                </div>
                                <div class="card-footer text-muted">
                                    <button class="btn btn-danger batalAntrian">Batalkan Antrian</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $('.batalAntrian').click(function() {
                Swal.fire({
                    title: 'Apa alasan anda ingin membatalkan antrian ?',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Batalkan Antrian',
                    showLoaderOnConfirm: true,
                    preConfirm: (keterangan) => {
                        var keterangan = keterangan;
                        var kodebooking = $('#kodebooking').val();
                        return {
                            keterangan: keterangan,
                            kodebooking: kodebooking,
                        }
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.LoadingOverlay("show");
                        var kodebooking = result.value.kodebooking;
                        var keterangan = result.value.keterangan;
                        $.ajax({
                            url: "{{ route('batalantrianweb') }}",
                            data: {
                                kodebooking: kodebooking,
                                keterangan: keterangan,
                            },
                            type: "GET",
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                if (data.metadata.code == 200) {
                                    Swal.fire({
                                        title: 'Success',
                                        text: data.metadata.message,
                                        icon: 'success',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        $.LoadingOverlay("show");
                                        window.location.href =
                                            "{{ route('statusantrian') }}" +
                                            "?kodebooking=" +
                                            kodebooking;
                                    })
                                } else {
                                    Swal.fire({
                                        title: 'Maaf',
                                        text: data.metadata.message,
                                        icon: 'error',
                                        confirmButtonText: 'Tutup'
                                    });
                                }
                                $.LoadingOverlay("hide");
                            },
                            error: function(data) {
                                console.log(data);
                                alert('Error');
                                $.LoadingOverlay("hide");
                            },
                        });
                    }
                });
            });
        });
    </script>
@endsection
