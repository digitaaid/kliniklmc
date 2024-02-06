<div class="row">
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $antrians->where('taskid', '>=', 5)->where('taskid', '<', 7)->count() }}"
            text="Sisa Resep" theme="warning" icon="fas fa-user-injured" />
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $antrians->where('taskid', 7)->count() }}" text="Total Resep Selesai"
            theme="success" icon="fas fa-user-injured" />
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $antrians->where('taskid', 7)->where('jenispasien', 'JKN')->count() }}"
            text="Total Resep JKN" theme="primary" icon="fas fa-user-injured" />
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $antrians->where('taskid', 7)->where('jenispasien', 'NON-JKN')->count() }}"
            text="Total Resep NON-JKN" theme="primary" icon="fas fa-user-injured" />
    </div>
</div>
@php
    $heads = ['No', 'Kodebooking', 'No RM', 'Pasien', 'Unit', 'Dokter', 'Jenis Pasien', 'Status', 'Action'];
    $config['order'] = [[7, 'asc']];
    $config['paging'] = false;
    $config['scrollY'] = '300px';
@endphp
<x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable compressed>
    @if ($antrians)
        @foreach ($antrians as $item)
            <tr>
                <td>{{ $item->angkaantrean }}</td>
                <td>{{ $item->kodebooking }}</td>
                <td>{{ $item->norm }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->kunjungan ? $item->kunjungan->units->nama : '-' }}</td>
                <td>{{ $item->namadokter }}</td>
                <td>{{ $item->jenispasien }} </td>
                <td>
                    @switch($item->taskid)
                        @case(0)
                            <span class="badge badge-secondary">98. Belum Checkin</span>
                        @break

                        @case(1)
                            <span class="badge badge-warning">97. Menunggu Pendaftaran</span>
                        @break

                        @case(2)
                            <span class="badge badge-primary">96. Proses Pendaftaran</span>
                        @break

                        @case(3)
                            <span class="badge badge-warning">95. Menunggu Poliklinik</span>
                        @break

                        @case(4)
                            <span class="badge badge-primary">94. Pelayanan Poliklinik</span>
                        @break

                        @case(5)
                            <span class="badge badge-warning">5. Tunggu Farmasi</span>
                        @break

                        @case(6)
                            <span class="badge badge-primary">6. Racik Obat</span>
                        @break

                        @case(7)
                            <span class="badge badge-success">7. Selesai</span>
                        @break

                        @case(99)
                            <span class="badge badge-danger">99. Batal</span>
                        @break

                        @default
                            {{ $item->taskid }}
                    @endswitch
                </td>
                <td>
                    @switch($item->taskid)
                        @case(5)
                            <a href="{{ route('terimafarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                class="btn btn-xs btn-warning withLoad">Terima</a>
                        @break

                        @case(6)
                            <x-adminlte-button icon="fas fa-edit" class="btn-xs" theme="success" label="Edit"
                                onclick="editResep(this)" data-kode="{{ $item->kodebooking }}" />
                            <a href="{{ route('selesaifarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                class="btn btn-xs btn-success withLoad"> Selesai</a>
                        @break

                        @case(7)
                            <a href="{{ route('print_asesmenfarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                class="btn btn-xs btn-warning" target="_blank"> <i class="fas fa-print"></i>
                                Print</a>
                            <x-adminlte-button icon="fas fa-edit" class="btn-xs" theme="warning" onclick="editResep(this)"
                                data-kode="{{ $item->kodebooking }}" />
                            <a href="{{ route('panggilpendaftaran') }}?kodebooking={{ $item->kodebooking }}"
                                class="btn btn-primary btn-xs withLoad">
                                <i class="fas fa-volume-down"></i>
                            </a>
                        @break

                        @default
                            <div class="btn btn-xs btn-secondary">
                                Belum
                            </div>
                    @endswitch
                </td>
            </tr>
        @endforeach
    @endif
</x-adminlte-datatable>
