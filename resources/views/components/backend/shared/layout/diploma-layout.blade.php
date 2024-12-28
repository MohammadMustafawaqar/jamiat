<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Diploma | {{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-rtl/bootstrap-rtl.min.css') }}">
    <style>
        @font-face {
            font-family: 'Bahij';
            src: url("{{ asset('assets/fonts/Bahij/bahij-nassim-bold1.ttf') }}");
            font-weight: bolder;
        }

        * {
            font-family: 'Bahij';
            font-size: 22px;
            line-height: 2;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        .container-custom {
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Vertically center the content */
            height: 100%;
        }

        @media print {

            @page {
                margin: 3cm;
                size: landscape;
            }

            * {
                font-family: 'Bahij';
                font-size: 21.33px;
                line-height: 2;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            p {

                margin: 0;
                line-height: 2;

            }

            .main-text {
                font-family: 'Bahij';
                font-size: 22px;
                line-height: 2;
                text-align: justify;

            }



        }
    </style>
    @stack('styles')
</head>

<body dir="rtl">
    {{ $slot }}

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.close(); 
            };
        }
    </script>
    @stack('scripts')

</body>

</html>
