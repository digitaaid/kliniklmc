<div class="col-md-2 border border-dark">
    <div class="m-2  text-center">
        <img class="" src="{{ asset('medicio/assets/img/lmc.png') }}" style="height: 80px">
    </div>
</div>
<div class="col-md-6  border border-dark">
    <b>KLINIK UTAMA LUTHFI MEDICAL CENTER</b><br>
    Jl. Raya Sunan Gunung Jati No. 100 A/B <br>
    Desa Pasindangan Kec. Gunungjati Kab. Cirebon Jawa Barat 45151<br>
    www.luthfimedicalcenter.com - Whatasapp 0823 1169 6919 -
    Call Center (0231) 8850943
</div>
<div class="col-md-4  border border-dark">
    <div class="row">
        <div class="p-2">
            {!! QrCode::size(70)->generate($kunjungan->norm) !!}
        </div>
        <div>
            No RM : <b>{{ $kunjungan->norm }}</b> <br>
            Nama : <b>{{ $kunjungan->nama }}</b> <br>
            Tgl Lahir : <b>{{ $kunjungan->tgl_lahir }}
                ({{ \Carbon\Carbon::parse($kunjungan->tgl_lahir)->diffInYears($kunjungan->tgl_masuk) }}
                tahun)</b> <br>
            Kelamin : <b>{{ $kunjungan->gender }}</b>
        </div>
    </div>
</div>
