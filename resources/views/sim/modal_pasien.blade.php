<x-adminlte-modal id="modalPasien" name="modalPasien" title="Pasien" theme="success" icon="fas fa-user-injured"
    size="xl">
    <div class="row">
        <div class="col-md-7">
            <x-adminlte-button id="btnTambah" class="btn-sm mb-2" theme="success" label="Tambah Pasien"
                icon="fas fa-plus" />
        </div>
        <div class="col-md-5">
            <form action="" method="get">
                <x-adminlte-input name="search" placeholder="Pencarian No RM / BPJS / NIK / Nama" igroup-size="sm">
                    <x-slot name="appendSlot">
                        <x-adminlte-button id="btnCariPasien" theme="primary" icon="fas fa-search" label="Cari" />
                    </x-slot>
                </x-adminlte-input>
            </form>
        </div>
    </div>
    @php
        $heads = ['No RM', 'No BPJS', 'NIK', 'Nama Pasien', 'Tgl Lahir', 'Action'];
        $config['paging'] = false;
        $config['info'] = false;
        $config['searching'] = false;
    @endphp
    <x-adminlte-datatable id="tablePasien" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
        compressed>
    </x-adminlte-datatable>
</x-adminlte-modal>
@push('js')
    <script>
        function modalPasien() {
            $('#modalPasien').modal('show');
        }
    </script>
@endpush
