<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            text-align: right;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .header {
            border-bottom: 1px solid #000;
            margin-bottom: 20px;
            text-align: center;
        }
        .header img {
            vertical-align: middle;
        }
        .header .left {
            float: left;
            width: 50px;
            height: 50px;
            border: 1px solid #000;
            text-align: center;
            line-height: 50px;
        }
        .header .center {
            display: inline-block;
            width: calc(100% - 150px);
        }
        .header .right {
            float: right;
            width: 50px;
            height: 50px;
            border: 1px solid #000;
            text-align: center;
            line-height: 50px;
        }
        .clear {
            clear: both;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }
        .form-group label {
            flex: 1;
            padding: 8px;
            border-bottom: 1px solid #ccc;
        }
        .input-group {
            flex: 2;
            display: flex;
        }
        .input-group input {
            flex: 1;
            text-align: center;
            border: 1px solid #ccc;
            margin: 2px;
            padding: 8px;
        }
        .photo-box {
            border: 1px solid #000;
            width: 100px;
            height: 130px;
            text-align: center;
            line-height: 130px;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="left">
                <img src="student_image.png" alt="Student Image">
            </div>
            <div class="center">
                <h1>د افغانستان اسلامي امارت</h1>
                <h2>د لوړو زده کړو وزارت</h2>
                <h3>د دیني علومو او تخصصاتو د عالي دورې ریاست</h3>
                <h4>د خارج جواز د دیني علومو د عالي دورې (ماستري) د استاد د تمدید لپاره</h4>
            </div>
            <div class="right">
                <img src="afghanistan_logo.png" alt="Afghanistan Logo">
            </div>
            <div class="clear"></div>
        </div>
        <div class="photo-box">
            3 x 4
        </div>
        <form>
            <div class="form-group">
                <label>نوم:</label>
                <div class="input-group">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                    <!-- Repeat as needed for each digit -->
                </div>
            </div>
            <div class="form-group">
                <label>تخلص:</label>
                <div class="input-group">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                    <!-- Repeat as needed for each digit -->
                </div>
            </div>
            <!-- Repeat for other fields -->
            <div class="footer">
                <p>یادونه: لطفاً د استاد د تذکرې او د دیني علومو د عالي دورې د سند کاپي په لاندې ځای کې د ضمیمې په توګه نښلول کړئ.</p>
                <p>د سند کاپي باید په A4 کاغذ کې او د عکس اندازه (3x4 cm) وي.</p>
            </div>
        </form>
    </div>
</body>
</html>
