<x-adminlte-modal id="modalRujukan" name="modalRujukan" title="Peserta Rujukan Peserta" theme="success"
    icon="fas fa-file-medical" size="xl">
    @php
        $heads = ['tglKunjungan', 'noKunjungan', 'provPerujuk', 'Nama', 'jnsPelayanan', 'poli', 'Action'];
        $config['paging'] = false;
        $config['info'] = false;
        $config['order'] = ['0', 'desc'];
    @endphp
    <x-adminlte-datatable id="tableRujukan" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
        compressed>
    </x-adminlte-datatable>
</x-adminlte-modal>

