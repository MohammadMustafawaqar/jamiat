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
                <div class="col-8">
                    <div class="text-center">
                        <p style="margin: 0.7">د افغانستان اسلامي امارت</p>
                        <p style="margin: 0.7">د لوړو زده کړو وزارت</p>
                        <p style="margin: 0.7">د دیني جامعاتو او تخصصاتو عمومي ریاست</p>
                        <p style="margin: 1">
                            د ا.ا.ا. په لومړې دور کې د {{ $frm->grade->localized_name }} دورې د ارزیابي شویو او د تعلیم، تربیې او عالي
                            تحصیلاتو کمېسیون لخوا د ورکړل شویو اسنادو د ارزیابې او برابرې لپاره د نوم لیکنې فورمه
                        </p>
                    </div>
                </div>
                <div class="col-2">
                    <img src="{{ asset('assets/logos/mohe_logo.png') }}" alt="" height="100" width="100">
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
                        <p class="mb-0" style="text-overflow: show; white-space: nowrap;">د خپل پلار نوم په لاندې هره خانه کې په دقیق ډول په یو یو حرف ولیکئ!</p>
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
                    <div class="mt-2">
                        <p class="mb-0" style="text-overflow: show; white-space: nowrap;">د خپل نیکه نوم په لاندې هره خانه کې په دقیق ډول په یو یو حرف ولیکئ!</p>
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
                    <div class="mb-2">
                        اصلي استوګنڅی: ولایت . . . . . . . . . . . . . . . . . . . . ولسوالي / ناحیه . . . . . . . . . .
                        . . . . . . . . . کلی / کوڅه . . . . . . . . . . . . . . . . .
                    </div>
                    <div class="mb-2">
                        فعلي استوګنڅی: ولایت . . . . . . . . . . . . . . . . . . . . ولسوالي / ناحیه . . . . . . . . . .
                        . . . . . . . . . کلی / کوڅه . . . . . . . . . . . . . . . . . کور نمبر . . . . . . . . . .
                    </div>
                    <div class="mb-2">
                        د زده کړې هېواد . . . . . . . . . . . . . . . . . ښار: . . . . . . . . . . . . . . جامعه . . . .
                        . . . . . . . . . فراغت کال: . . . . . . . . . . . . . . تقدیر: . . . . . . . . . .
                    </div>
                    <div class="mb-2">
                        د اړیکې شمېره: . . . . . . . . . . .  . . . . . . . د واټساپ شمېره: . . . . . . . . . .
                        . . . . . . . . . . . . . د ګډون کونکي قریب یوه فعاله شمېره: . . . . . . . . . . . . . .
                        . . . . .
                    </div>
                </div>
                <div class="col-12 mt-4">
                    ما پورته فورمه په پوره دقت سره ډکه کړې ده او هر ډول غلطۍ او تېروتنې مسؤلیت په غاړه اخلم.
                </div>
                <div class="col-12 mt-4 row border-bottom">
                    <div class="col-8">
                        د فورمې د تسلیمۍ نیټه:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ {{ $frm->qamari_year }}
                        هـ ق
                    </div>
                    <div class="col-4 text-left">
                        د فاضل لاسلیک: . . . . . . . . . . . . . .
                    </div>
                </div>
                <div class="col-12 mt-4 py-4" style="width: 100%">
                    <div>
                        <div class="text-center">
                            <strong>د ارزیابې ریاست لخوا د {{ $frm->grade->localized_name }} دورې د سند تائید</strong>
                            <p>
                                اسنادو ته په کتنې سره (. . . . . . . . . . . . . . . . . . .) د (. . . . . . . . . . . . . .
                                . . . . .) زوی په (. . . . . . . . . . . . . .) کال کې د (. . . . . . . . . . . . . . . . .
                                . .) مدرسې له {{ $frm->grade->localized_name }} دورې سند یې په (. . . . . . . . . . . . . .) نیټه د (. . .
                                . . . . . . . . . . .) شوی دی، زموږ سره د (. . . . . . . . . . . . . .) جلد په اساس کتاب (.
                                . . . . . . . . ) پاڼه کې په (. . . . . . . . . .) نمبر ثبت دی، نوموړی سند د اعتبار وړ او
                                زموږ لخوا تائید دی.
                            </p>
                            <p>
                                په درنښت !
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 row">
                    <div class="col-6">
                        <div class="box-container">
                            <span> د تصدیق کوونکي آمر: </span>
                            <span class="box rounded-1"
                                style="height: 15px !important; width: 20px; margin: 0px 10px;"></span>
                            <span>
                                داخل مرز
                            </span>
                            <span class="box rounded-1"
                                style="height: 15px !important; width: 20px; margin: 0px 10px;"></span>
                            <span>
                                خارج مرز
                            </span>
                        </div>
                    </div>
                    <div class="col-6 text-left">
                        د تصدیق کوونکي آمر لاسلیک: . . . . . . . . . . . . . . . . . . . . . . . 
                    </div>
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
