@extends('adminlte::printer')
@section('title', 'Print Asesmen Keperawatan Rawat Jalan')
@section('content_header')
    <h1>Print Asesmen Keperawatan Rawat Jalan</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="printMe">
                @include('form.resume_rajal')
            </div>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Select2', true)
@section('css')
    <style>
        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            font-size: 11px !important;
        }

        dd,
        dl,
        dt {
            margin-bottom: 0 !important;
        }
    </style>
    <style type="text/css" media="print">
        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }

        dd,
        dl,
        dt {
            margin-bottom: 0 !important;
        }

        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            font-size: 11px !important;
        }

        .main-footer {
            display: none !important;
        }

        .btnPrint {
            display: none !important;
        }
    </style>
@endsection
@section('js')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            tampilan_print = document.body.innerHTML = printContents;
            setTimeout('window.addEventListener("load", window.print());', 1000);
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            window.print();
        });
        setTimeout(function() {
            window.top.close();
        }, 2000);
    </script>
@endsection
