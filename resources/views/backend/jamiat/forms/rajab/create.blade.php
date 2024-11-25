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
    </style>
</head>

<body>
    @foreach ($form as $frm)
        <div class="container-fluid borders pt-3">
            <div class="row">
                <div class="col-2">
                    <img src="{{ asset('assets/logos/eia-logo-final.png') }}" alt="" height="100"
                        width="120">
                    <div class="text-nowrap">
                        <p class="mt-2 mb-0">سنة الاختبار: {{ $frm->qamari_year }} هـ.ق</p>
                        <p class="p-0 m-0">مطابق: {{ $frm->shamsi_year }} هـ.ش</p>
                    </div>
                </div>
                <div class="col-8">
                    <div class="text-center">
                        <p>ورقة الالحاق للاختبار السنوي</p>
                        <p>المرحلة {{ $grade_name }}
                            {{ $grade_classes }}
                        </p>
                    </div>

                </div>
                <div class="col-2">
                    <img src="{{ asset('assets/logos/mohe_logo.png') }}" alt="" height="100" width="100">
                </div>
            </div>

            <div class="row borders m-b">
                <div class="col-12 text-center">
                    خاص بالاستعمال الرسمي
                </div>
                <div class="col-12">
                    <span>رقم المسلسل: </span>
                    <span>{{ $frm->formatted_serial_number }}</span>
                </div>
                <div class="col-12">
                    <span>رقم الجلوس: </span>
                    <span>ــــــــــــــــــــــــــــــــــــــــــــــ</span>
                </div>
            </div>

            <div class="row borders m-b">
                <div class="col-12">
                    <div class="m-l">
                        <span>۱ - </span>
                        <span>الطالب : </span>
                        <span> _____________________________ </span>
                        <span>بن : </span>
                        <span> _____________________________ </span>
                        <span>بن : </span>
                        <span> _____________________________ </span>
                    </div>
                    <div class="m-l">
                        <span>۲ - </span>
                        <span>المولود :&nbsp; </span>
                        <span> _________________ </span>
                        <span>هـ ق الموافق لعام :&nbsp; </span>
                        <span> _________________ </span>
                        <span>هـ ش :&nbsp; </span>
                        <span> _________________ </span>
                        <span>م :&nbsp; </span>
                        <span> _________________ </span>
                    </div>
                    <div class="m-l">
                        <span>۳ - </span>
                        <span>العنوان الحالی ولایة : </span>
                        <span> ______________________ &nbsp; </span>
                        <span>مدیریة/ناحیة : </span>
                        <span> ______________________ &nbsp; </span>
                        <span>قریة : </span>
                        <span> _____________________ &nbsp; </span>
                    </div>
                    <div class="m-l">
                        <span>۴ - </span>
                        <span>العنوان الاصلی ولایة : </span>
                        <span> ______________________ &nbsp; </span>
                        <span>مدیریة/ناحیة : </span>
                        <span> _______________________ </span>
                        <span>قریة : </span>
                        <span> _____________________ &nbsp; </span>
                    </div>
                    <div class="m-l">
                        <span>۵ - </span>
                        <span>اسم الجامعة و عنوانها : </span>
                        <span> ___________________________________________________________________________________
                        </span>
                    </div>
                    <div class="m-l">
                        <span>۶ - </span>
                        <span>رقم بطاقة الهویة : </span>
                        <span> ______________________ &nbsp; </span>
                        <span>۷ - رقم الهاتف : </span>
                        <span> _____________________ </span>
                        <span>توقع الطالب : </span>
                        <span> ___________________ &nbsp; </span>
                    </div>
                </div>
            </div>

            <div class="row borders m-b" style="font-size: 16px;">
                <strong style="font-size: 18px">
                    تصدیق الجامعة :
                </strong>
                تشهد ان ما كتبه الطالب في ورقة الالتحاق صحيح، وقد أتم دراسة المرحلة {{ $grade_name }} في جامعتنا في
                هذه السنة
                فيستحق
                المشاركة في الاختبار السنوي.

                <div class="emp">
                    <span>
                        توقیع المهتمم :
                    </span>
                    <span>
                        _____________________________
                    </span>
                    <span>
                        ختم الجامعة :
                    </span>
                    <span>
                        ____________________________
                    </span>
                    <span>
                        توقيع التعليمات الإسلامية :
                    </span>
                    <span>
                        ____________________
                    </span>
                    <span>
                        توقيع رئيسة المصارف :
                    </span>
                    <span>
                        ____________________
                    </span>
                    <div>
                        تذکیر: النسخة الملونة من بطاقة هوية هامة مع الاستمارة.
                    </div>
                </div>
                <div style="font-size: 18px;">
                    <strong>
                        نوټ :
                    </strong>
                    <span>د تذکرې رنګه کاپي د فورم سره ضروري ده.</span>
                    </span>
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
