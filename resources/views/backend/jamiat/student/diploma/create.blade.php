<x-diploma title="Diploma">
    @push('styles')
        <style>
            @font-face {
                font-family: 'Bahij';
                src: url("assets/fonts/Bahij/bahij-nassim-bold.ttf");
                font-weight: bold;
                font-style: normal;
            }

            body {

                font-family: 'Bahij';
                font-size: 21.33px;
                text-align: justify;
            }

            .container-fluid {
                width: 100%;
                height: 100%;
                padding: 0;
                margin: 0;
                position: relative;
            }

            .student-container {
                width: 100%;
                height: 100%;
                page-break-after: auto;
                page-break-inside: avoid;
                display: flex;
                flex-direction: column;
                justify-content: center;
                text-align: center;
            }

            .smaller-text {
                font-size: 20px;
                word-wrap: nowrap;
                white-space: nowrap;
            }



            .main-text {
                font-family: 'Bahij';
                font-size: 21.22px;
                line-height: 2.5;
                text-align: justify;
            }

            .underline-text {
                position: relative;
                display: inline-block;
                padding: 0px 15px;
                /* Adjust space between text and underline */
            }

            .underline-text::after {
                content: '';
                position: absolute;
                bottom: 10px;
                left: 0;
                width: 100%;
                height: 2px;
                background-color: black;
            }

            @media print {

                .underline-text {
                    display: inline-block !important;
                    /* Ensure the inline-block behavior for print */
                    padding: 0px 15px !important;
                    /* Adjust padding for print */
                }

                .underline-text::after {
                    content: '';
                    position: absolute;
                    bottom: 10px;
                    left: 0;
                    width: 100%;
                    height: 2px;
                    background-color: black;
                }


            }
        </style>
    @endpush

    <div class="container-fluid">
        @foreach ($students as $student)
            <div class="student-container mt-5">
                <div class="row mb-3 align-items-center smaller-text">
                    <div class="col-3 text-right">
                        <p class="smaller-text">رقم التسجیل: </p>
                    </div>
                    <div class="col-6 text-center">
                        <p class="smaller-text">شهادة {{ $student->exams()->first()->grade->name }} ({{ $student->exams()->first()->grade->arabic_equivalent }})</p>
                        <p class="smaller-text">{{ $student->exams()->first()->grade->english_equivalent }}</p>
                    </div>
                    <div class="col-3 text-left">
                        <p class="smaller-text">رقم المسلسل: {{ $student->form_id }}</p>
                    </div>
                </div>
                <div>
                    <p class="main-text">
                        الحمد للّه ربّ العالمين، والصلوة والسلام على سیّدالمرسلين، وعلى آله وأصحابه أجمعين، وبعد:
                        <br />
                        فإن الرئاسة العامة لشؤون الجامعات والتخصصات الدينية تشهد بأن
                        <span class="underline-text">{{ $student->full_name }}</span> بن <span
                            class="underline-text">{{ $student->father_name }}</span> المولود عام
                       <span class="underline-text"> {{ JamiaHelper::getYearFromDob($student->dob_qamari) }}</span> هـ ق قد أتمّ المتطلبات الدراسیّة
                        لجامعة <span class="underline-text">{{ $student->school->name }}</span>
                        ونـجـح في الاختبار المنعقد عام <span
                            class="underline-text">1446</span> هـ ق تحت إشراف
                        هذه الرئاسة، و وزیر التعلیم العالي إذ یمنحه
                        شهادة
                        العالمیة (
                        الماجستیر )یوصیه بتقوی الله تعالی ویسأل الله عزَّوجلَّ أن یوفّقه لخدمة الإسلام والمسلمین
                    </p>
                </div>
                <div class="row justify-content-between text-center mt-2">
                    <div class="col-6">
                        <p>توقیع</p>
                        <p>الرئيس العام لشؤون الجامعات والتخصصات الدینیة</p>
                    </div>
                    <div class="col-4">
                        <p>توقیع</p>
                        <p>وزیر التعلیم العالي</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-diploma>
