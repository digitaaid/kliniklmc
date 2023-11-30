<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=80mm, initial-scale=1.0">
    <title>Karcis Antrian</title>
</head>
<body>
    <div class="ticket">
        <img src="{{ asset('medicio/assets/img/lmc-l.png') }}" width="200px" alt="">
        <hr>
        <p>
            <b style="font-size: 25px"> Karcis Antrian</b>
        </p>
        <p>
            Nomor Antrian <br>
            <b style="font-size: 40px">{{ $antrian->nomorantrean }}</b> <br>
            {!! QrCode::size(100)->generate($antrian->kodebooking) !!} <br>
            Kodebooking <br><b>{{ $antrian->kodebooking }} / {{ $antrian->angkaantrean }}</b>
        </p>
        <p>
            {{ $antrian->jenispasien }}
            @if ($antrian->method != 'OFFLINE')
                <b>{{ $antrian->nama }}</b> <br>
                No RM {{ $antrian->norm }} <br>
                No BPJS {{ $antrian->nomorkartu }} <br>
            @endif
        </p>
        <p>
            {{ $antrian->namapoli }} <br>
            {{ $antrian->namadokter }} <br>
            {{ $antrian->jampraktek }} <br>
        </p>
        <hr>
        <p style="line-height:12px;font-size: 10px;">
            Simpan lembar karcis antrian ini sampai pelayanan berakhir. Terimakasih. <br>
            Semoga selalu diberikan kesembuhan dan kesehatan.
        </p>
    </div>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            window.print();
        });
        setTimeout(function() {
            var url = "{{ route('anjunganantrian') }}";
            window.location.href = url;
        }, 3000);
    </script>
</body>

</html>
