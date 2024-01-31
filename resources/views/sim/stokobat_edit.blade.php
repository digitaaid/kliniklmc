  <form action="{{ route('update_kartustokobat') }}" id="formEditStokObat" name="formEditStokObat" method="POST"
      enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="obat_id" value="{{ $obat->id }}">
      <input type="hidden" name="stok_id" value="{{ $stok->id }}">
      <x-adminlte-input name="nama" label="Nama Obat" value="{{ $obat->nama }}" placeholder="Nama Obat"
          fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
          required />
      <x-adminlte-input name="harga_beli" class="uang" label="Harga Beli Kemasan" placeholder="Harga Beli"
          fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
          required value="{{ $obat->harga_beli }}" />
      <x-adminlte-input name="diskon_beli" type="number" max="100" min="0" label="Diskon Pembelian"
          placeholder="Diskon Pembelian" fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
          igroup-class="col-9" enable-old-support required value="{{ $obat->diskon_beli }}" />
      <x-adminlte-input name="jumlah_kemasan" label="Jumlah Kemasan" placeholder="Jumlah Kemasan" fgroup-class="row"
          label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support />
      <x-adminlte-input name="jumlah" label="Jumlah Satuan" placeholder="Jumlah Satuan" fgroup-class="row"
          label-class="text-right col-3" value="{{ $stok->jumlah }}" igroup-size="sm" igroup-class="col-9"
          enable-old-support />
      @php
          $config = ['format' => 'YYYY-MM-DD'];
      @endphp
      <x-adminlte-input-date name="tgl_input" label="Tgl Input" fgroup-class="row" label-class="text-right col-3"
          igroup-size="sm" igroup-class="col-9" value="{{ now()->format('Y-m-d') }}" placeholder="Pilih Tanggal"
          :config="$config">
      </x-adminlte-input-date>
      <x-adminlte-input-date name="tgl_expire" label="Tgl Expire" fgroup-class="row" label-class="text-right col-3"
          igroup-size="sm" igroup-class="col-9" value="{{ now()->format('Y-m-d') }}" placeholder="Pilih Tanggal"
          :config="$config">
      </x-adminlte-input-date>
      <x-slot name="footerSlot">
          <x-adminlte-button form="formStok" class="mr-auto" type="submit" icon="fas fa-save" theme="success"
              label="Import" />
          <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
      </x-slot>
  </form>
