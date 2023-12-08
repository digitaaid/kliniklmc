<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collLay" aria-expanded="true"
        aria-controls="collLay">
        <h3 class="card-title">
            Layanan & Tindakan
        </h3>
        <div class="card-tools">
            @if ($antrian->layanan)
                {{ $antrian->layanan->layanandetails->count() ?? 0 }}
            @endif Layanan
            <i class="fas fa-info-circle"></i>
        </div>
    </a>
    <div id="collLay" class="show collapse" role="tabpanel">
        <div class="card-body">
            @php
                $heads = ['Tgl Input', 'Action', 'Layanan/Tindakan', 'Jaminan', 'Harga @ Jumlah', 'Diskon', 'Subtotal'];
                $config['paging'] = false;
                $config['searching'] = false;
                $config['info'] = false;
                $config['bLengthChange'] = false;
                $config['ordering'] = false;
            @endphp
            <button type="button" class="btn btn-xs btn-success mb-2 tambahLayanan">
                <i class="fas fa-plus"></i> Tambah Layanan
            </button>
            <button type="button" class="btn btn-xs btn-success mb-2 getLayananKunjungan">
                <i class="fas fa-sync"></i> Refresh Layanan
            </button>
            <x-adminlte-datatable id="tableLayanan" :heads="$heads" :config="$config" bordered hoverable compressed>
            </x-adminlte-datatable>
        </div>
    </div>
</div>
