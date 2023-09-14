<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=80mm, initial-scale=1.0">
    <title>Test Printer</title>
</head>

<body>
    <div class="ticket">
        <h3>Test Printer</h3>
        <p>Ukuran 80 mm x 120mm</p>
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
