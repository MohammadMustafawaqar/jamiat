<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Form</title>
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-rtl/bootstrap-rtl.min.css') }}">
    <style>
        @font-face {
            font-family: 'Amiri';
            /* Choose a name for your font */
            src: url("{{ asset('assets/fonts/Amiri/Amiri-Bold.ttf') }}") format('woff2'),
                url("{{ asset('assets/fonts/Amiri/Amiri-Regular.ttf') }}") format('woff'),
                url("{{ asset('assets/fonts/Amiri/Amiri-BoldItalic.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Noto';
            /* Choose a name for your font */
            src: url("{{ asset('assets/fonts/Noto_Naskh_Arabic/NotoNaskhArabic-VariableFont_wght.ttf') }}") format('woff2');
            font-weight: normal;
            font-style: normal;
        }

        * {
            font-family: 'Noto';
            font-size: 14px;
        }

        .borders {
            border: 1px solid #444;
        }

        .m-b {
            margin: 25px 0.5px;
            padding: 5px 3px;
        }

        .m-l {
            margin-top: 35px;
        }

        .emp>* {
            font-size: 18px;
            font-weight: bold;
        }

        .text-nowrap {
            white-space: nowrap;
            overflow: show;
            text-overflow: ellipsis;
        }

        .border-bottom {
            border-bottom: 1px solid #444 !important;
        }

        .box-container {
            display: flex;
            flex-wrap: nowrap;
            /* Keeps the boxes in one line */
        }

        .box {
            width: 40px;
            height: 20px;
            border: 1px solid black;
            box-sizing: border-box;
        }

        .dots {
            display: inline-block;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            font-size: 20px;
            line-height: 1;
            /* Adjust line height */
        }

        @media print {
            * {
                font-family: 'Noto';
                font-size: 14px;
            }

            .borders {
                border: 1px solid #444;
            }

            .m-b {
                margin: 25px 0.5px;
                padding: 5px 3px;
            }

            .m-l {
                margin-top: 35px;
            }

            .emp>* {
                font-size: 18px;
                font-weight: bold;
            }

            .text-nowrap {
                white-space: nowrap;
                overflow: show;
                text-overflow: ellipsis;
            }

            .border-bottom {
                border-bottom: 1px solid #444 !important;
            }

            .box-container {
                display: flex;
                flex-wrap: nowrap;
                /* Keeps the boxes in one line */
            }

            .box {
                width: 40px;
                height: 20px;
                border: 1px solid black;
                box-sizing: border-box;
            }

            .dots {
                display: inline-block;
                width: 100%;
                white-space: nowrap;
                overflow: hidden;
                font-size: 20px;
                line-height: 1;
            }
        }
    </style>
</head>

<body>
    @php
        $dots = ' <span style="dots">
                            . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . 
                </span>';
        $boxes = '<div class="box-container">
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                            <div class="box"></div>
                        </div>';
    @endphp
    @foreach ($form as $frm)
        <div class="container-fluid borders pt-3">
            <div class="row border-bottom border-1 p-2">
               
                <div class="col-2">
                    <img src="{{ asset('assets/logos/eia-logo-final.png') }}" alt="" height="100"
                        width="120">
                </div>
                <div class="col-6">
                    <div class="text-center">
                        <p style="margin: 0.4">د افغانستان اسلامي امارت</p>
                        <p style="margin: 0.4">د لوړو زده کړو وزارت</p>
                        <p style="margin: 0.4">د دیني جامعاتو او تخصصاتو د چارو لوی ریاست</p>
                        <p style="margin: 1; white-space: nowrap; text-overflow: visible;">
                            د {{ $frm->addressType->name }} د دیني جامعاتو د {{ $frm->grade->name }} دورې ({{ $frm->grade->equivalent }}) د اسنادو ارزونې فورمه
                        </p>
                    </div>
                </div>
                <div class="col-2">
                    <img src="{{ asset('assets/logos/mohe_logo.png') }}" alt="" height="100" width="100">
                </div>
                <div class="col-2">
                    <div class="text-center border row align-content-center" style="height: 3.5cm; width: 3cm;" dir="ltr">
                        <p class="col-12">انځور</p>
                        <p class="col-12">3 X 4</p>
                    </div>
                </div>
                <div class="col-12 row mt-2" style="width: 100%;">
                    <div class="col-4">
                        مسلسل شمېره: {{ $frm->formatted_serial_number }}
                    </div>
                    <div class="col-4 text-center">
                        ګڼه: . . . . . . . . . . . . . . . .
                    </div>
                    <div class="col-4 text-center">
                        نیټه: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/{{ $frm->qamari_year }} هـ ق
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <div class="mt-2">
                        <span class="mb-0">نوم / اسم:</span>
                        {!! $dots !!}
                    </div>
                    <div class="mt-2">
                        <p class="mb-0">خپل نوم په لاندې هره خانه کې په دقیق ډول په یو یو حرف ولیکئ!</p>
                        {!! $boxes !!}
                    </div>
                    <div class="mt-3">
                        <span class="mb-0 ">د پلار نوم / ولد:</span>
                        {!! $dots !!}
                    </div>
                    <div class="mt-2">
                        <p class="mb-0">خپل پلار نوم په لاندې هره خانه کې په دقیق ډول په یو یو حرف ولیکئ!</p>
                        {!! $boxes !!}
                    </div>
                </div>
                <div class="col-6">
                    <div class="mt-2">
                        <span class="mb-0">تخلص:</span>
                        {!! $dots !!}
                    </div>
                    <div class="mt-2">
                        <p class="mb-0">خپل تخلص په لاندې هره خانه کې په دقیق ډول په یو یو حرف ولیکئ!</p>
                        {!! $boxes !!}
                    </div>
                    <div class="mt-3">
                        <span class="mb-0">
                            د نیکه نوم / ولدیت:
                        </span>
                            {!! $dots !!}
                    </div>
                    <div class="mt-3">
                        <p class="mb-0">خپل نیکه نوم په لاندې هره خانه کې په دقیق ډول په یو یو حرف ولیکئ!</p>
                        {!! $boxes !!}
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6 mb-1">
                    د زیږیدو نیټه: (د زیږیدو هجري قمري نیټه باید د تذکرې مطابق وي).
                </div>
                <div class="col-6 mb-1">
                    کال هجري قمري: . .  . . . . . . . . میاشت: . . . . . . . . ورځ: . . . . . . . . . . .
                    .
                </div>
                <div class="col-12 mb-3">
                    مورنې ژبه: . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
                </div>
                <div class="col-12 mb-3">
                    <div>
                        <div class="d-inline">
                            <div class="box-container">
                                <span> د تذکرې نمبر: </span>
                                (<span class="box rounded-1"
                                    style="height: 15px !important; width: 20px; margin: 0px 10px;"></span>
                                <span>
                                    برقي /
                                </span>
                                <span class="box rounded-1"
                                    style="height: 15px !important; width: 20px; margin: 0px 10px;"></span>
                                <span>
                                    کاغذي
                                </span>)
                                <span style="margin-right: 10px; max-width: 50%">
                                    {!! $boxes !!}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12">
                    <div class="mb-1">
                        اصلي استوګنڅی: ولایت . . . . . . . . . . . . . . . . . . . . ولسوالي / ناحیه . . . . . . . . . .
                        . . . . . . . . . کلی / کوڅه . . . . . . . . . . . . . . . . .
                    </div>
                    <div class="mb-1">
                        فعلي استوګنڅی: ولایت . . . . . . . . . . . . . . . . . . . . ولسوالي / ناحیه . . . . . . . . . .
                        . . . . . . . . . کلی / کوڅه . . . . . . . . . . . . . . . . . کور نمبر . . . . . . . . . .
                    </div>
                    <div class="mb-1">
                        د زده کړې هېواد . . . . . . . . . . . . . . . . . ښار: . . . . . . . . . . . . . . جامعه . . . .
                        . . . . . . . . . فراغت کال: . . . . . . . . . . . . . . تقدیر: . . . . . . . . . .
                    </div>
                    <div class="mb-1">
                        د عصري زده کړو کچه: {!! $dots !!} {!! $dots !!} . . . . . . . . . . . . . . 
                    </div>
                    <div class="mb-1">
                        د اړیکې شمېره: . . . . . . . . . . .  . . . . . . . د واټساپ شمېره: . . . . . . . . . .
                        . . . . . . . . . . . . . د ګډون کونکي قریب یوه فعاله شمېره: . . . . . . . . . . . . . .
                        . . . . .
                    </div>
                </div>
                <div class="col-12 mt-2">
                    ما پورته فورمه په پوره دقت سره ډکه کړې ده او هر ډول غلطۍ او تېروتنې مسؤلیت په غاړه اخلم.
                </div>
                <div class="col-12 mt-2 row border-bottom" style="width: 100%">
                    <div class="col-8">
                        د فورمې د تسلیمۍ نیټه:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ {{ $frm->qamari_year }}
                        هـ ق
                    </div>
                    <div class="col-4 text-left">
                        د طالب العلم لاسلیک: . . . . . . . . . . . . . .
                    </div>
                </div>
                <div class="col-12 mt-2 py-2" style="width: 100%">
                    <div>
                        <div class="text-center">
                            <strong>د اړوند جامعې لخوا د {{ $grade_name }} دورې د سند تائید</strong>
                            <p>
                                زه . . . . . . . . . . . . . . د . . . . . . . . . . . . . .  زوی د . . . . . . . . . . . . . .  ولایت د . . . . . . . . . . . . . .  ولسوالي د تذکرې نمبر . . . . . . . . . . . . . .  د جامعې مهتمم په حیث دنده لرم. د پورته شهرت لرونکي طالب العلم پوره تصدیق کوم، چې نوموړی له {{ $frm->grade->name }} دورې په یاده جامعه کې د فراغت سند ترلاسه کړی. د جعل په صورت کې د اسلامي امارت ټولو اصولي او قانوني اجراآتو ته ژمن یم، نو په همدې اساس هیله ده چې . . . . . . . . . . . . . .  د . . . . . . . . . . . . . .  زوی/لور ستاسې د اسنادو د برابرې او ارزونې د پروسې مستحق وګڼل شي.
                            </p>
                            <p>
                                په درنښت !
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 row border-bottom " >
                    <div class="col-6">
                        د تصدیق کوونکي د اړیکې شمېره: . . . . . . . . . . . . . .  
                    </div>
                    <div class="col-6 text-left">
                        د تصدیق کوونکي  لاسلیک او مهر: . . . . . . . . . . . . . . . . . . . . . . . 
                    </div>
                </div>
                <div class="col-12 py-3">
                    <strong>یادونه: </strong> لطفاً د اسنادو د ارزونې لپاره د نوم لیکنې پورتنې فورمه د همدې پاڼې پر بل مخ د لیکل شویو لارښوونو مطابق ډکه کړئ او د اړوند ولایت پوهنتون / موسسې مربوط مرجع ته د سپارلو پر مهال اصلي تذکرې کاپي، د سند کاپي، او شیږ قطعې اوسني عکسونه چې اندازه یې (3X4 cm <sup>2</sup>) او د شا پرده یې سپینه وي، ضمیمه کړئ.
                </div>
            </div>


        </div>
    @endforeach
    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.close(); 
            };
        }
    </script>
</body>

</html>
