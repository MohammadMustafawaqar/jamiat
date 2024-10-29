<!DOCTYPE html>
<html lang="ps">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Cards</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #555b6184;
            margin: 0;
            padding: 0;
        }

        .card-container {
            width: 100%;
            margin: 20px 0;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: right;
            direction: rtl;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .title-section {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            color: #007bff;
        }

        .title-section div {
            margin: 2px 0;
        }

        .divider {
            border-bottom: 2px solid #007bff;
            margin: 10px 0;
        }

        .card-content {
            font-size: 16px;
            color: #333;
        }

        .card-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .card-field {
            width: 48%;
        }

        .card-label {
            font-weight: bold;
            color: #555;
        }

        .card-value {
            color: #007bff;
        }

        @media print {
            body {
                background-color: #c79191;
            }

            .card-container {
                border: 1px solid #333;
                background-color: #bbb !important;
                box-shadow: none;
                margin: 10px 0;
                padding: 15px;
                page-break-inside: avoid; /* Avoid splitting cards between pages */
            }

            .divider {
                border-color: #333;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            @foreach ($students as $student)
                <div class="col-6" style="border-right: 3px dotted black; border-bottom: 3px dotted black">
                    <div class="card-container">
                        <!-- Header with logos and titles -->
                        <div class="card-header">
                            <img src="{{ asset('assets/logos/eia-logo.png') }}" alt="Logo 1" class="logo"> <!-- Left logo -->
                            <div class="title-section">
                                <div>د افغانستان اسلامي امارت</div>
                                <div>د لوړو زده کړو وزارت</div>
                                <div>د دیني جامعاتو او تخصصاتو ریاست</div>
                                <div>د {{ $student->exams->first()?->title }} ازموینې کارت</div>
                            </div>
                            <img src="{{ asset('assets/logos/mohe_logo.png') }}" alt="MOHE" class="logo"> <!-- Right logo -->
                        </div>

                        <div class="divider"></div> <!-- Divider below the title section -->

                        <!-- Student Information Section -->
                        <div class="card-content">
                            <div class="card-row">
                                <div class="card-field">
                                    <span class="card-label">فورم ایډی: </span>
                                    <span class="card-value">{{ $student->form_id }}</span>
                                </div>
                                <div class="card-field">
                                    <span class="card-label">مسلسل نمبر: </span>
                                    <span class="card-value">{{ $student->id }}</span>
                                </div>
                            </div>
                            <div class="card-row">
                                <div class="card-field">
                                    <span class="card-label">نوم: </span>
                                    <span class="card-value">{{ $student->name }}</span>
                                </div>
                                <div class="card-field">
                                    <span class="card-label">د پلار نوم: </span>
                                    <span class="card-value">{{ $student->father_name }}</span>
                                </div>
                            </div>
                            <div class="card-row">
                                <div class="card-field">
                                    <span class="card-label">د نیکه نوم: </span>
                                    <span class="card-value">{{ $student->grand_father_name }}</span>
                                </div>
                                <div class="card-field">
                                    <span class="card-label">تذکره نمبر: </span>
                                    <span class="card-value" dir="ltr">{{ $student->tazkira?->tazkira_no }}</span>
                                </div>
                            </div>
                            <div class="card-row">
                                <div class="card-field">
                                    <span class="card-label">د اړیکې شمېره: </span>
                                    <span class="card-value" dir="ltr">{{ $student->phone }}</span>
                                </div>
                                <div class="card-field">
                                    <span class="card-label">د امتحان ځای: </span>
                                    <span class="card-value" dir="ltr">{{ $student->studentExams()->first()->class->address }}</span>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            @endforeach
           
        </div>
    </div>
    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
