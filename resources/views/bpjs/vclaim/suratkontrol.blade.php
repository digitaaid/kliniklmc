@extends('adminlte::page')
@section('title', 'Surat Kontrol')
@section('content_header')
    <h1>Surat Kontrol</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" theme-mode="outline">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            @php
                                $config = [
                                    'timePicker' => false,
                                    'locale' => ['format' => 'YYYY/MM/DD'],
                                ];
                            @endphp
                            <x-adminlte-date-range fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="tanggal" :config="$config" label="Tanggal"
                                value="{{ $request->tanggal ?? null }}" />
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="formatfilter" label="Format Filter">
                                <option value="1" {{ $request->formatfilter == '1' ? 'selected' : null }}>Tanggal Entri
                                </option>
                                <option value="2" {{ $request->formatfilter == '2' ? 'selected' : null }}>Tanggal
                                    Rencana Kontrol
                                </option>
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" class="withLoad" theme="primary" icon="fas fa-search"
                                        label="Cari" />
                                </x-slot>
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-button theme="success" class="btn-sm" label="Buat S. Kontrol"
                                icon="fas fa-file-medical" onclick="buatSuratKontrol()" />
                            <x-adminlte-button theme="success" class="btn-sm" label="Buat SPRI"
                                icon="fas fa-file-medical" />
                        </div>
                    </div>

                </form>
                @php
                    $heads = [
                        'No Surat',
                        'Nama',
                        'No BPJS',
                        'Action',
                        'Tgl Kontrol',
                        'Tgl Terbit',
                        'Digunakan',
                        'Pelayanan',
                        'Jenis Surat',
                        'Poli Asal',
                        'Poli Tujuan',
                        'Dokter',
                        'No SEP Asal',
                        'Tgl SEP',
                    ];
                    $config['scrollX'] = true;
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable
                    compressed>
                    @if (isset($suratkontrols))
                        @foreach ($suratkontrols as $item)
                            <tr>
                                <td>{{ $item->noSuratKontrol }}</td>
                                <td>{{ $item->noKartu }} </td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    <x-adminlte-button class="btn-xs" theme="success" icon="fas fa-print"
                                        onclick="printSuratKontrol(this)"
                                        data-nosuratkontrol="{{ $item->noSuratKontrol }}" />
                                    @if ($item->terbitSEP != 'Sudah')
                                        <x-adminlte-button class="btn-xs" theme="warning" icon="fas fa-edit" />
                                        <x-adminlte-button class="btn-xs" theme="danger" icon="fas fa-trash" />
                                    @endif
                                </td>
                                <td>{{ $item->tglRencanaKontrol }}</td>
                                <td>{{ $item->tglTerbitKontrol }}</td>
                                <td>{{ $item->terbitSEP }}</td>
                                <td>{{ $item->jnsPelayanan }}</td>
                                <td>{{ $item->namaJnsKontrol }}</td>
                                <td>{{ $item->namaPoliAsal }}</td>
                                <td>{{ $item->namaPoliTujuan }}</td>
                                <td>{{ $item->namaDokter }}</td>
                                <td>{{ $item->noSepAsalKontrol }}</td>
                                <td>{{ $item->tglSEP }}</td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalPrintSuratKontrol" title="Print Surat Kontrol" size="xl" theme="success"
        icon="fas fa-file-medical">
        <div id="iframeLoader" class="loader">
            <h4>Loading...</h4>
        </div>
        <iframe src="" id="iframeSuratKontrol" onload="iframeLoaded()" width="100%" height="500px"
            frameborder="0"></iframe>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="Tutup" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalBuatSuratKontrol" title="Buat Surat Kontrol" size="xl" theme="success"
        icon="fas fa-file-medical">
        <form action="{{ route('suratkontrol.store') }}" id="formSuratKontrol" method="POST">
            @csrf
            {{-- <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}"> --}}
            {{-- <input type="hidden" name="antrian_id" value="{{ $antrian->id }}"> --}}
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="nomorkartu" label="Nomor Kartu" placeholder="Nomor Kartu" />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="noSEP" label="Nomor SEP" placeholder="Nomor SEP" readonly>
                <x-slot name="appendSlot">
                    <x-adminlte-button theme="primary" label="Cari SEP" icon="fas fa-search" onclick="cariSEP()" />
                </x-slot>
            </x-adminlte-input>
            @php
                $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="tglRencanaKontrol" label="Tgl Kontrol" placeholder="Pilih Tanggal Rencana Kontrol"
                :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="poliKontrol" label="Poliklinik">
                <option selected disabled>Silahkan Klik Cari Poliklinik</option>
                <x-slot name="appendSlot">
                    <x-adminlte-button theme="primary" label="Cari Poli" icon="fas fa-search" onclick="cariPoli()" />
                </x-slot>
            </x-adminlte-select>
            <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="kodeDokter" label="Dokter">
                <option selected disabled>Silahkan Klik Cari Dokter</option>
                <x-slot name="appendSlot">
                    <x-adminlte-button theme="primary" label="Cari Dokter" icon="fas fa-search"
                        onclick="cariDokter()" />
                </x-slot>
            </x-adminlte-select>
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto withLoad" theme="success" form="formSuratKontrol" type="submit"
                label="Buat Surat Kontrol" />
            <x-adminlte-button theme="danger" label="Tutup" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalSEP" name="modalSEP" title="SEP Peserta" theme="success" icon="fas fa-file-medical"
        size="xl">
        @php
            $heads = ['tglSep', 'tglPlgSep', 'noSep', 'jnsPelayanan', 'poli', 'diagnosa', 'Action'];
            $config['paging'] = false;
            $config['order'] = ['0', 'desc'];
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableSEP" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
            compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('js')
    {{-- toast --}}
    <script>
        var Toast = Swal.mixin({
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
    {{-- surat kontrol --}}
    <script>
        function printSuratKontrol(button) {
            $('#modalPrintSuratKontrol').modal('show');
            var nosuratkontrol = $(button).data('nosuratkontrol');
            var url = "{{ route('suratkontrol_print') }}?noSuratKontrol=" + nosuratkontrol;
            $('#iframeSuratKontrol').attr('src', url);
            $('#iframeLoader').show();
            $('#iframeSuratKontrol').hide();
        }

        function iframeLoaded() {
            $('#iframeLoader').hide();
            $('#iframeSuratKontrol').show();
        }

        function buatSuratKontrol() {
            $('#modalBuatSuratKontrol').modal('show');
        }

        function cariSEP() {
            $('#modalSEP').modal('show');
            $.LoadingOverlay("show");
            var table = $('#tableSEP').DataTable();
            table.rows().remove().draw();
            var nomorkartu = $('#nomorkartu').val();
            var url = "{{ route('suratkontrol_sep') }}?nomorkartu=" + nomorkartu;
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $.each(data.response, function(key, value) {
                            if (value.jnsPelayanan == 1) {
                                var jenispelayanan = "Rawat Inap";
                            }
                            if (value.jnsPelayanan == 2) {
                                var jenispelayanan = "Rawat Jalan";
                            }
                            var btnpilih =
                                "<button class='btn btn-success btn-xs' onclick='pilihSEP(this)'  data-nosep=" +
                                value.noSep +
                                ">Pilih</button>";
                            table.row.add([
                                value.tglSep,
                                value.tglPlgSep,
                                value.noSep,
                                jenispelayanan,
                                value.poli,
                                value.diagnosa,
                                btnpilih,
                            ]).draw(false);
                        });
                        Toast.fire({
                            icon: 'success',
                            title: data.metadata.message,
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.metadata.message,
                        });
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    Toast.fire({
                        icon: 'error',
                        title: data.metadata.message,
                    });
                    $.LoadingOverlay("hide");
                }
            });
        }

        function pilihSEP(button) {
            var nomorsep = $(button).data('nosep');
            $.LoadingOverlay("show");
            $('#noSEP').val(nomorsep);
            $('#modalSEP').modal('hide');
            $.LoadingOverlay("hide");
        }

        function cariPoli() {
            $.LoadingOverlay("show");
            var sep = $('#noSEP').val();
            var tanggal = $('#tglRencanaKontrol').val();
            var url = "{{ route('suratkontrol_poli') }}?nomor=" + sep + "&tglRencanaKontrol=" +
                tanggal + "&jenisKontrol=2";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $('#poliKontrol').empty()
                        $.each(data.response.list, function(key, value) {
                            optText = value.namaPoli + " (" + value.persentase +
                                "%)";
                            optValue = value.kodePoli;
                            $('#poliKontrol').append(new Option(optText, optValue));
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Poliklinik Ditemukan'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.metadata.message
                        });
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    Toast.fire({
                        icon: 'error',
                        title: data.metadata.message
                    });
                    $.LoadingOverlay("hide");
                }
            });
        }

        function cariDokter() {
            $.LoadingOverlay("show");
            var poli = $('#poliKontrol').find(":selected").val();
            var tanggal = $('#tglRencanaKontrol').val();
            var url = "{{ route('suratkontrol_dokter') }}?kodePoli=" + poli + "&tglRencanaKontrol=" +
                tanggal + "&jenisKontrol=2";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $('#kodeDokter').empty();
                        $.each(data.response.list, function(key, value) {
                            optText = value.namaDokter + " (" + value
                                .jadwalPraktek +
                                ")";
                            optValue = value.kodeDokter;
                            $('#kodeDokter').append(new Option(optText, optValue));
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Dokter Ditemukan'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.metadata.message
                        });
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    Toast.fire({
                        icon: 'error',
                        title: data.metadata.message
                    });
                    $.LoadingOverlay("hide");
                }
            });
        }
    </script>
@endsection
