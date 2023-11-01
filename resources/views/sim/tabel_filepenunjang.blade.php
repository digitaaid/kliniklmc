<div class="card card-info mb-1">
    <div class="card-header" role="tab" id="headFile">
        <h3 class="card-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFile"
                aria-expanded="true" aria-controls="collapseFile">
                File Penunjang ({{ $antrian->pasien->fileuploads->count() }} Berkas)
            </a>
        </h3>
    </div>
    <div id="collapseFile" class="collapse" role="tabpanel" aria-labelledby="headFile">
        <div class="card-body">
            <form action="{{ route('uploadpenunjang') }}" name="formFile" id="formFile"
                method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <input type="hidden" name="kodekunjungan"
                    value="{{ $antrian->kunjungan->kode ?? null }}">
                <input type="hidden" name="kunjungan_id"
                    value="{{ $antrian->kunjungan->id ?? null }}">
                <input type="hidden" name="norm" value="{{ $antrian->norm ?? null }}">
                <input type="hidden" name="namapasien" value="{{ $antrian->nama ?? null }}">
                <x-adminlte-input name="nama" placeholder="Nama / Keterangan File"
                    igroup-size="sm" label="Nama File" enable-old-support required />
                <x-adminlte-input-file name="file" placeholder="Pilih file yang akan diupload"
                    igroup-size="sm" label="Upload Image" />
                <button type="submit" form="formFile" class="btn btn-success">
                    <i class="fas fa-upload"></i> Upload
                </button>
            </form>
            <style>
                .card.card-tabs .card-tools {
                    margin: 0px !important;
                }
            </style>
            @if ($antrian->pasien)
                @if ($antrian->pasien->fileuploads)
                    <hr>
                    <div class="row">
                        @foreach ($antrian->pasien->fileuploads as $file)
                            <div class="col-md-6">
                                <x-adminlte-card header-class="p-2" body-class="p-0"
                                    title="{{ $file->nama }}" theme="secondary"
                                    icon="fas fa-file" collapsible="">
                                    <x-slot name="toolsSlot">
                                        Uploaded at : {{ $file->created_at }}
                                        <a href="{{ $file->fileurl }}" target="_blank"
                                            class="btn btn-xs btn-tool"><i
                                                class="fas fa-download"></i></a>
                                        <a href="{{ route('hapusfilepenunjang') }}?id={{ $file->id }}"
                                            class="btn btn-xs btn-tool"> <i
                                                class="fas fa-trash"></i></a>
                                    </x-slot>
                                    <object data="{{ $file->fileurl }}" width="100%"
                                        height="500px">
                                    </object>
                                </x-adminlte-card>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                @foreach ($antrian->fileuploads as $file)
                    <x-adminlte-card header-class="p-2" body-class="p-0"
                        title="{{ $file->nama }} {{ $file->created_at }}" theme="info"
                        icon="fas fa-file" collapsible="collapsed">
                        <x-slot name="toolsSlot" class="m-0">
                            Uploaded at : {{ $file->created_at }}
                            <a href="{{ $file->fileurl }}" target="_blank"
                                class="btn btn-xs btn-tool"><i class="fas fa-download"></i></a>
                            <a href="{{ route('hapusfilepenunjang') }}?id={{ $file->id }}"
                                class="btn btn-xs btn-tool"> <i class="fas fa-trash"></i></a>
                        </x-slot>
                        <object data="{{ $file->fileurl }}" width="100%" height="500px">
                        </object>
                    </x-adminlte-card>
                @endforeach
            @endif
        </div>
    </div>
</div>
