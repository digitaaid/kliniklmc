@extends('adminlte::master')
@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@section('title', 'Mesin Antrian')
@section('body')
    <link rel="shortcut icon" href="{{ asset('medicio/assets/img/lmc.png') }}" />
    <div class="wrapper">
        <div class="row p-1">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <p hidden>{{ setlocale(LC_ALL, 'IND') }}</p>
                <x-adminlte-card title="Informasi Antrian {{ \Carbon\Carbon::now()->formatLocalized('%A, %d %B %Y') }}"
                    theme="primary" icon="fas fa-calendar-alt">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $heads = ['Poliklinik', 'Dokter', 'Jam Praktek', 'Kuota', 'Antrian'];
                            @endphp
                            <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" striped bordered>
                                @foreach ($jadwals as $jadwal)
                                    <tr>
                                        <td>{{ $jadwal->namasubspesialis }}</td>
                                        <td>{{ $jadwal->namadokter }}</td>
                                        <td>{{ $jadwal->jadwal }}</td>
                                        <td>{{ $jadwal->kapasitaspasien }}</td>
                                        <td>{{ $jadwal->kuota }}</td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-info-box class="btnDaftarBPJS text-center" text="Ambil Antrian BPJS"
                                theme="success" />
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-info-box class="btnDaftarUmum text-center" text="Ambil Antrian Umum"
                                theme="success" />
                        </div>
                    </div>
                </x-adminlte-card>
                <x-adminlte-card title="Anjungan Checkin Antrian RSUD Waled" theme="primary" icon="fas fa-qrcode">
                    <div class="text-center">
                        <x-adminlte-input name="kodebooking" label="Silahkan scan QR Code Antrian atau masukan Kode Antrian"
                            placeholder="Masukan Kode Antrian untuk Checkin" igroup-size="lg">
                            <x-slot name="appendSlot">
                                <x-adminlte-button name="btn_checkin" id="btn_checkin" theme="success" label="Checkin!" />
                            </x-slot>
                            <x-slot name="prependSlot">
                                <div class="input-group-text text-success">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <i class="fas fa-qrcode fa-5x"></i>
                        <br>
                    </div>
                    <x-slot name="footerSlot">
                        <x-adminlte-button icon="fas fa-sync" class="withLoad reload" theme="warning" label="Reload" />
                        <a href="{{ route('cekPrinter') }}" class="btn btn-warning withLoad"><i class="fas fa-print"></i>
                            Test
                            Printer</a>
                        <a href="{{ route('checkinAntrian') }}" class="btn btn-warning withLoad"><i
                                class="fas fa-print"></i> Checkin
                            Antrian</a>
                    </x-slot>
                </x-adminlte-card>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="modalBPJS" size="xl" title="Ambil Antrian BPJS" theme="success" icon="fas fa-user-plus">
        @foreach ($jadwals as $jadwal)
            <a class="card bg-success" href="{{ route('ambilkarcis') }}?pasien=JKN&jadwal={{ $jadwal->id }}">
                <div class="card-body  text-center">
                    {{ $jadwal->jadwal }}
                    {{ $jadwal->namadokter }}
                    ({{ $jadwal->namasubspesialis }})
                </div>
            </a>
        @endforeach
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)-
@include('sweetalert::alert')
@section('adminlte_css')
@endsection
@section('adminlte_js')
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/loading-overlay/loadingoverlay.min.js') }}"></script>
    <script src="{{ asset('vendor/onscan.js/onscan.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- scan --}}
    <script>
        $(function() {
            onScan.attachTo(document, {
                onScan: function(sCode, iQty) {
                    $.LoadingOverlay("show", {
                        text: "Mencari kodebooking " + sCode + "..."
                    });
                    var url = "{{ route('checkinAntrian') }}?kodebooking=" + sCode;
                    window.location.href = url;
                    // $.LoadingOverlay("show", {
                    //     text: "Printing..."
                    // });
                    // var url = "{{ route('checkinUpdate') }}";
                    // var formData = {
                    //     kodebooking: sCode,
                    //     waktu: "{{ \Carbon\Carbon::now()->timestamp * 1000 }}",
                    // };
                    // $('#kodebooking').val(sCode);
                    // $.get(url, formData, function(data) {
                    //     console.log(data);
                    //     $.LoadingOverlay("hide");
                    //     if (data.metadata.code == 200) {
                    //         $('#status').html(data.metadata.message);
                    //         swal.fire(
                    //             'Sukses...',
                    //             data.metadata.message,
                    //             'success'
                    //         ).then(okay => {
                    //             if (okay) {
                    //                 $.LoadingOverlay("show", {
                    //                     text: "Reload..."
                    //                 });
                    //                 $('#status').html('-');
                    //                 location.reload();
                    //             }
                    //         });
                    //     } else {
                    //         $('#status').html(data.metadata.message);
                    //         swal.fire(
                    //             'Opss Error...',
                    //             data.metadata.message,
                    //             'error'
                    //         ).then(okay => {
                    //             if (okay) {
                    //                 $.LoadingOverlay("show", {
                    //                     text: "Reload..."
                    //                 });
                    //                 $('#status').html('-');
                    //                 location.reload();
                    //             }
                    //         });
                    //     }
                    // });
                },
            });
        });
    </script>
    {{-- btn chekin --}}
    <script>
        $(function() {
            $('#btn_checkin').click(function() {
                var kodebooking = $('#kodebooking').val();
                $.LoadingOverlay("show", {
                    text: "Mencari kodebooking " + kodebooking + "..."
                });
                var url = "{{ route('checkinAntrian') }}?kodebooking=" + kodebooking;
                window.location.href = url;
                // var kodebooking = $('#kodebooking').val();
                // $.LoadingOverlay("show", {
                //     text: "Printing..."
                // });
                // var url = "{{ route('checkinUpdate') }}";
                // var formData = {
                //     kodebooking: kodebooking,
                //     waktu: "{{ \Carbon\Carbon::now()->timestamp * 1000 }}",
                // };
                // $('#kodebooking').val(kodebooking);
                // $.get(url, formData, function(data) {
                //     console.log(data);
                //     $.LoadingOverlay("hide");
                //     if (data.metadata.code == 200) {
                //         $('#status').html(data.metadata.message);
                //         swal.fire(
                //             'Sukses...',
                //             data.metadata.message,
                //             'success'
                //         ).then(okay => {
                //             if (okay) {
                //                 $.LoadingOverlay("show", {
                //                     text: "Reload..."
                //                 });
                //                 $('#status').html('-');
                //                 location.reload();
                //             }
                //         });
                //     } else {
                //         $('#status').html(data.metadata.message);
                //         swal.fire(
                //             'Opss Error...',
                //             data.metadata.message,
                //             'error'
                //         ).then(okay => {
                //             if (okay) {
                //                 $.LoadingOverlay("show", {
                //                     text: "Reload..."
                //                 });
                //                 $('#status').html('-');
                //                 location.reload();
                //             }
                //         });
                //     }
                // });
            });
        });
    </script>
    {{-- btn daftar --}}
    <script>
        $(function() {
            $(document).ready(function() {
                $('#daftarDokter').hide();
                setTimeout(function() {
                    $('#kodebooking').focus();
                }, 500);
            });
            $('.btnDaftarBPJS').click(function() {
                $('#modalBPJS').modal('show');
                $('#inputNIK').show();
                $('#btnDaftarPoliUmum').hide();
                $('#btnDaftarPoliBPJS').show();
                $('#inputKartu').show();
                setTimeout(function() {
                    $('#nomorkartu').focus();
                }, 500);

            });
            $('.btnDaftarUmum').click(function() {
                $('#modalBPJS').modal('show');
                $('#inputNIK').show();
                $('#inputKartu').hide();
                $('#btnDaftarPoliUmum').show();
                $('#btnDaftarPoliBPJS').hide();
                setTimeout(function() {
                    $('#nik').focus();
                }, 500);

            });
            $('.btnPoliBPJS').click(function() {
                $('div#rowDokter').children().remove();
                var id = $(this).data('id');
                var hari = "{{ now()->dayOfWeek }}"
                $.LoadingOverlay("show");
                var url = "{{ route('jadwaldokterPoli') }}/?kodesubspesialis=" + id + "&hari=" +
                    hari;
                $.get(url, function(data) {
                    $('#daftarDokter').show();
                    $.each(data, function(i, item) {
                        console.log(item.kodedokter);
                        var bigString = [
                            '<div class="custom-control custom-radio " >',
                            '<input class="custom-control-input btnPoliBPJS" type="radio"',
                            'data-id="' + item.kodedokter + '" id="' + item.kodedokter +
                            '"',
                            'value="' + item.kodedokter + '" name="kodedokter">',
                            '<label for="' + item.kodedokter +
                            '" class="custom-control-label"',
                            'data-id="' + item.kodedokter + '">' + item.namadokter +
                            ' </label>',
                            ' </div>',
                        ];
                        $('#rowDokter').append(bigString.join(''));
                    });
                    $.LoadingOverlay("hide", true);
                });
            });
            $('#btnDaftarPoliBPJS').click(function() {
                var kodesubspesialis = $("input[name=kodesubspesialis]:checked").val();
                var kodedokter = $("input[name=kodedokter]:checked").val();
                var url = "{{ route('daftarBpjsOffline') }}" + "?kodesubspesialis=" +
                    kodesubspesialis + "&kodedokter=" + kodedokter;
                window.location.href = url;
            });
            $('#btnDaftarPoliUmum').click(function() {
                var kodesubspesialis = $("input[name=kodesubspesialis]:checked").val();
                var kodedokter = $("input[name=kodedokter]:checked").val();
                var url = "{{ route('daftarUmumOffline') }}" + "?kodesubspesialis=" +
                    kodesubspesialis + "&kodedokter=" + kodedokter;
                window.location.href = url;
            });

        });
    </script>
    {{-- withLoad --}}
    <script>
        $(function() {
            $(".withLoad").click(function() {
                $.LoadingOverlay("show");
            });
        })
        $('.reload').click(function() {
            location.reload();
        });
    </script>
@stop
