@extends('vendor.medico.master')
@section('title', 'Daftar Antrian Umum')
@section('content')
    <!-- ======= Appointment Section ======= -->
    <br><br><br><br>
    <section id="appointment" class="appointment section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Daftar Antrian Umum</h2>
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
            <form action="{{ route('prosesdaftarumum') }}" id="formDaftar" method="POST" role="form" data-aos="fade-up"
                data-aos-delay="100">
                @csrf
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="nik" id="nik" placeholder="NIK Pasien"
                        value="{{ $request->nik }}" {{ $request->nomorkartu ? 'readonly' : null }}>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="nohp" id="nohp" placeholder="Nomor HP"
                        value="{{ $request->nohp }}">
                </div>
                @if ($request->nik && $request->nohp)
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="nomorkartu" id="nomorkartu"
                            placeholder="Nomor Kartu BPJS" value="{{ $request->nomorkartu }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama"
                            value="{{ $request->nama }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="norm" id="norm" placeholder="Nomor RM"
                            value="{{ $request->norm }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control datepicker" name="tanggalperiksa" id="tanggalperiksa"
                            placeholder="Tanggal Periksa" value="{{ $request->tanggalperiksa }}">
                    </div>
                @endif
                @if ($request->tanggalperiksa && $jadwals->count())
                    <div class="form-group mb-3">
                        <select name="jadwal" id="jadwal" class="form-select" required>
                            <option selected disabled>Pilih jadwal dokter</option>
                            @foreach ($jadwals as $item)
                                <option value="{{ $item->id }}">{{ $item->jadwal }} {{ $item->namasubspesialis }}
                                    {{ $item->namadokter }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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
@endsection
