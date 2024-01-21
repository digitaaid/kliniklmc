<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Preview - 2 Halaman F4</title>
    <link rel="stylesheet" href="path/to/bootstrap-grid.min.css">
    <link rel="stylesheet" href="{{ asset('medilab/assets/vendor/bootstrap/css/bootstrap-grid.min.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        .page {
            width: 21cm;
            height: 13cm;
            margin: 1cm auto;
            padding: 1cm;
            /* border: 1px solid #ccc; */
            background-color: white;
            overflow: hidden;
            page-break-after: always;
            position: relative;
            border: 1px solid black !important;
        }

        .border {
            border: 1px solid black !important;
        }

        .text-center {
            text-align: center !important;
        }

        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 13px;
        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f0f0f0;
            text-align: center;
            padding: 0.2cm;
            border: 1px solid black !important;
        }

        @media print {
            body {
                margin: 0;
            }

            .page {
                margin: 0;
                border: initial;
            }

            pre {
                border: none;
                outline: none;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 13px;
            }

            .footer {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                background-color: #f0f0f0;
                text-align: center;
                padding: 0.2cm;
            }

            /* Hide the button in print mode */
            button {
                display: none !important;
            }
        }

        /* Style for the Print button */
        button {
            display: block;
            margin: 0 auto;
            /* Center the button horizontally */
            margin-top: 1cm;
            /* Add some top margin for separation */
            padding: 0.5cm 1cm;
            /* Padding for a better appearance */
            font-size: 16px;
            /* Adjust font size */
            background-color: #00cc00;
            /* Green color */
            color: white;
            /* Text color */
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="page">

    </div>
    <button onclick="printPage()">Print</button>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</body>

</html>
