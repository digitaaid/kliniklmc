@extends('adminlte::page')
@section('title', 'Assesmen Dokter')
@section('content_header')
    <h1>Assesmen Dokter</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" theme-mode="outline">
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
                    class="btn btn-danger btn-sm mb-2 mr-1 withLoad">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('panggilpendaftaran') }}?kodebooking={{ $antrian->kodebooking }}"
                    class="btn btn-primary btn-sm mb-2 mr-1 withLoad">
                    <i class="fas fa-sync"></i> Panggil
                </a>
                <div class="btn btn-sm btn-{{ $antrian->taskid == 5 ? 'success' : 'secondary' }} mb-2 mr-1">
                    <i class="fas fa-{{ $antrian->taskid == 5 ? 'check-circle' : 'info-circle' }}"></i>
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
                @include('sim.antrian_profil3')
            </x-adminlte-card>
        </div>
        @if ($antrian->kunjungan)
            <div class="col-md-3">
                <x-adminlte-card id="nav" theme="primary" title="Navigasi" body-class="p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item" onclick="modalIcare()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-file-medical"></i> I-Care JKN
                            </a>
                        </li>
                        <li class="nav-item" onclick="modalCPPT()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-file-medical"></i> CPPT
                                <span class="badge bg-success float-right">
                                    {{ $antrian->pasien ? $antrian->pasien->kunjungans->count() : 0 }} Kunjungan
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" onclick="btnFileUplpad()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-file-medical"></i> Berkas File Upload
                                <span class="badge bg-success float-right">
                                    {{ $antrian->pasien ? $antrian->pasien->fileuploads->count() : 0 }} Berkas File
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" onclick="tambahLayanan()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-hand-holding-medical"></i> Layanan & Tindakan
                                <span class="badge bg-success float-right">
                                    {{ $antrian->layanans->count() }} Layanan
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" onclick="btnAsesmenRajal()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-user-md"></i> Anamnesa Keperawatan
                                @if ($antrian->asesmenperawat)
                                    <span class="badge bg-success float-right">
                                        {{ $antrian->asesmenperawat->pic ?? null }}
                                    </span>
                                @else
                                    <span class="badge bg-danger float-right">Belum Asesmen</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item" onclick="btnAsesmenRajal()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-user-md"></i> Pemeriksaan Dokter
                                @if ($antrian->asesmendokter)
                                    <span class="badge bg-success float-right">
                                        {{ $antrian->asesmendokter->pic->name ?? null }}
                                    </span>
                                @else
                                    <span class="badge bg-danger float-right">Belum Pemeriksaan</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item" onclick="btnAsesmenRajal()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-file-medical-alt"></i> Asesmen Rawat Jalan
                            </a>
                        </li>
                        <li class="nav-item" onclick="btnResumeRajal()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-file-medical-alt"></i> Resume Rawat Jalan
                            </a>
                        </li>
                    </ul>
                    <x-slot name="footerSlot">
                        <x-adminlte-button label="Selesai Pelayanan" class="btn-sm" icon="fas fa-user-md" theme="success" onclick="modalSelesaiRajal()" />
                        <a href="{{ route('batalantrian') }}?kodebooking={{ $antrian->kodebooking }}&keterangan=Dibatalkan dipendaftaran {{ Auth::user()->name }}"
                            class="btn btn-sm btn-danger withLoad">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </x-slot>
                </x-adminlte-card>
            </div>
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 600px ;">
                        <div id="accordion" role="tablist" aria-multiselectable="true">
                            @include('sim.modal_icare')
                            @include('sim.modal_cppt')
                            @include('sim.modal_fileupload')
                            @include('sim.modal_layanan')
                            @include('sim.modal_asesmen_rajal')
                            @include('sim.modal_resume_rajal')
                            @include('sim.tabel_lab')
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger">
                    Pasien Belum Masuk Kunjungan
                </x-adminlte-alert>
            </div>
        @endif
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.BsCustomFileInput', true)
@section('js')
    {{-- toast --}}
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    </script>
    <script>
        function btnSBAR() {
            $.LoadingOverlay("show");
            $('#modalSBAR').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnPengkajianPerawat() {
            $.LoadingOverlay("show");
            $('#modalAsesmenPerawat').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnPemeriksaanDokter() {
            $.LoadingOverlay("show");
            $('#modalAsesmenDokter').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endsection
