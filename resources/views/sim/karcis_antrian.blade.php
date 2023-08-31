<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=80mm, initial-scale=1.0">
    <title>Karcis Antrian</title>
</head>

<body>
    <div class="ticket">
        <h3>Karcis Antrian</h3>
        <p>Kode Antrian: <br>
            {!! QrCode::size(100)->generate($antrian->kodebooking) !!} <br>
            <b>{{ $antrian->kodebooking }}</b>
        </p>
        <p>
            <b>{{ $antrian->nama }}</b> <br>
            No RM {{ $antrian->norm }} <br>
            No BPJS {{ $antrian->nomorkartu }} <br>
        </p>
        <p>
            {{ $antrian->namapoli }} <br>
            {{ $antrian->namadokter }} <br>
            {{ $antrian->jampraktek }}
        </p>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
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
