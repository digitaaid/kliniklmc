<div class="card card-info mb-1">
    <div class="card-header" role="tab" id="headLay">
        <h3 class="card-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collLay" aria-expanded="true" aria-controls="collLay">
                Layanan & Tindakan (@if ($antrian->layanan)
                    {{ $antrian->layanan->layanandetails->count() ?? 0 }}
                @endif Layanan)
            </a>
        </h3>
    </div>
    <div id="collLay" class="collapse" role="tabpanel" aria-labelledby="headLay">
        <div class="card-body">
            <style>
                .cariLayanan {
                    width: 300px !important;
                }
            </style>
            <form action="{{ route('editlayananpendaftaran') }}" method="POST">
                @csrf
                <input type="hidden" name="kodekunjungan" value="{{ $antrian->kodekunjungan }}">
                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan_id }}">
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <input type="hidden" name="norm" value="{{ $antrian->norm }}">
                <input type="hidden" name="nama" value="{{ $antrian->nama }}">
                <div class="row">
                    <div class="col-md-6">
                        <label class="mb-2">Layanan & Tindakan Pasien :
                        </label>
                        <button id="addLayanan" type="button" class="btn btn-xs btn-success mb-2">
                            <span class="fas fa-plus">
                            </span> Tambah Layanan
                        </button>
                        @if ($antrian->layanan)
                            @foreach ($antrian->layanan->layanandetails as $tarif)
                                <div id="row">
                                    <div class="form-group">
                                        <div class="input-group input-group-sm">
                                            <select name="layanan[]" class="form-control cariLayanan">
                                                <option value="{{ $tarif->tarif_id }}">
                                                    {{ $tarif->nama }}
                                                    {{ money($tarif->harga, 'IDR') }}</option>
                                            </select>
                                            <input type="number" name="jumlah[]" placeholder="Jumlah"
                                                value="{{ $tarif->jumlah }}" class="form-control" multiple>
                                            <button type="button" class="btn btn-xs btn-danger" id="deleteLayanan"><i
                                                    class="fas fa-trash "></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div id="rowTindakan">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select name="layanan[]" class="form-control cariLayanan">
                                    </select>
                                    <input type="number" name="jumlah[]" placeholder="Jumlah" class="form-control"
                                        multiple>
                                    <button type="button" class="btn btn-xs btn-warning">
                                        <i class="fas fa-hand-holding-medical "></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="newLayanan"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Layanan Pasien</label>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="kemoterapi" name="kemoterapi"
                                    value="1"
                                    @if ($antrian->layanan) {{ $antrian->layanan->kemoterapi ? 'checked' : null }} @endif>
                                <label for="kemoterapi" class="custom-control-label">Kemoterapi</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="Laboratorium"
                                    name="laboratorium" value="1"
                                    @if ($antrian->layanan) {{ $antrian->layanan->laboratorium ? 'checked' : null }} @endif>
                                <label for="Laboratorium" class="custom-control-label">Laboratorium</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="radiologi" name="radiologi"
                                    value="1"
                                    @if ($antrian->layanan) {{ $antrian->layanan->radiologi ? 'checked' : null }} @endif>
                                <label for="radiologi" class="custom-control-label">Radiologi</label>
                            </div>
                        </div>
                        <label>User : </label>
                        @if ($antrian->layanan)
                            {{ $antrian->layanan->pic->name }}
                        @endif <br>
                        <label>Updated at : </label>
                        @if ($antrian->layanan)
                            {{ $antrian->layanan->updated_at }}
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-success withLoad">
                    <i class="fas fa-edit"></i> Simpan Layanan & Tindakan
                </button>
            </form>
        </div>
    </div>
</div>
