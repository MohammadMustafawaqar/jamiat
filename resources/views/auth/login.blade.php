<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-rtl/bootstrap-rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .body-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 93.3vh;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('assets/logos/mohe_0.png') }}') no-repeat center center/cover;
            opacity: 0.7;
            /* Adjust this value for desired opacity */
            z-index: -1;
            /* Place the background behind content */
        }

        /* Container Styles */
        .login-container {
            display: flex;
            height: 80vh;
            width: 60vw;
            background: transparent;
            border-radius: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        /* Left Section (Login Form) */
        .left-section {
            padding: 40px;
            background: transparent;
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-left: 60px;
        }

        .left-section h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .left-section p {
            font-size: 14px;
            color: #555;
            margin-bottom: 30px;
        }

        .form-group {
            width: 90%;
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #6a11cb;
        }

        /* Button Styling */
        .login-btn {
            width: 90%;
            padding: 12px;
            background: #193a79;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }

        .login-btn:hover {
            background: #428bca;
        }

        /* Utility Links */
        .utility {
            display: flex;
            justify-content: space-between;
            width: 90%;
            font-size: 14px;
            color: #666;
            margin-top: 10px;
        }

        .utility a {
            color: #193a79;
            text-decoration: none;
            transition: color 0.3s;
        }

        .utility a:hover {
            color: #2575fc;
        }

        /* Right Section (Welcome Message) */
        .right-section {
            background: linear-gradient(17deg, #5aabf2, #4a87c8, #193a79);

            /* background: #2574fc; */
            backdrop-filter: blur(10px);

            color: #fff;
            /* display: flex; */
            display: none;
            flex-direction: column;
            /* justify-content: center; */
            align-items: center;
            text-align: center;
            /* clip-path: polygon(0 0, 100% 0, 100% 100%, 20% 100%); */
        }

        .right-section h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .right-section p {
            font-size: 16px;
            line-height: 1.5;
        }

        /* Social Login Section */
        .social-login {
            margin-top: 20px;
        }

        .social-login span {
            color: #555;
            font-size: 14px;
        }

        .social-icons {
            margin-top: 10px;
        }

        .social-icons a {
            color: #6a11cb;
            font-size: 24px;
            margin-right: 15px;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: #2575fc;
        }
    </style>
</head>

<body dir='rtl'>

    <div class="container-fluid">
        <div class="body-container">
            <div class="login-container row">
               

                <div class="right-section col-md-6 px-5 d-flex " dir="rtl">
                    <div class="" style="margin-top: 6.7rem">
                        <img src="{{ asset('assets/logos/eia-logo2.png') }}" alt="" height="150" width="200"
                            style="border-radius: 50%;">
                        <div class="mt-4">
                            <h2>د افغانستان اسلامي امارت</h2>
                            <h3>د لوړو زده کړو وزارت</h3>
                            <h6>د دیني جامعاتو او تخصصاتو لوی ریاست</h6>
                        </div>
                    </div>

                </div>

                <!-- Right Section - Welcome Message -->

                 <!-- Left Section - Form -->
                 <div class="left-section col-md-6">

                    <div class="mb-3 mx-auto">
                        <img src="{{ asset('assets/logos/mohe_logo.png') }}" alt="" width="150"
                            height="150" style="border-radius: 50%">
                    </div>

                    <form class="login-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Username Field -->
                        <div class="form-group">
                            <input type="text" name="email" placeholder="ایمیل / اړیکې شمېره" required autocomplete="email"
                                autofocus class="@error('email') is-invalid @enderror form-control" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <input type="password" name="password" placeholder="پاسورډ" required
                                autocomplete="current-password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password Links -->
                        <div class="utility">
                            <label class="text-light">
                                <input type="checkbox" name="remember" > ما په یاد ولره
                            </label>
                            <a href="{{ route('password.request') }}" class="text-light">پاسورډ بدل کړئ!</a>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="login-btn">ننوتل</button>
                    </form>

                </div>

            </div>
        </div>

        <div class="row bg-white p-2" style="color: #2575fc">
            <div class="col-4">
                Developed by: MOHE IS team
            </div>
            <div class="col-8 text-end">
                <h5>
                    د کاپی حق خوندي دی
                </h5>
            </div>
        </div>
    </div>


</body>

</html>
