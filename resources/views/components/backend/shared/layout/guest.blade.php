<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> MOHE</title>
    @include('backend.layout.style')
    <link rel="icon" type="image/png" href="{{asset(Settings::get()->larg_logo) }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">

</head>


<body id="body">

    <!--==========================
      Top Bar
    ============================-->
    <section id="topbar" class="d-none d-lg-block">
        <div class="container clearfix">
            <div class="contact-info float-left">
                <p class="d-inline">
                    <a href="mailto:contact@example.com">info@mohe.com</a>
                    <i class="fa fa-envelope"></i>
                </p>
                <i class="fa fa-line"></i>
                <i class="fa fa-phone d-inline"></i> +93 202 55488 55
            </div>
            {{-- <div class="social-links float-right">
                <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
                <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
                <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
            </div> --}}
        </div>
    </section>

    <!--==========================
      Header
    ============================-->
    <header id="header">
        <div class="container">

            <nav class="navbar navbar-expand-lg row">
                <div id="logo" class="col-8 mb-1">
                    <h1>
                        <a href="{{ route('evaluation.index') }}" class="scrollto">
                            <span id="full-text">
                                {{ Settings::trans('Ministry of ', ' د لوړو زده کړو', ' وزارت ') }}
                                {{ Settings::trans('Higher Education', ' وزارت ', 'تحصیلات عالي') }}
                            </span>
                            <span id="short-text" style="display: none;">MOHE</span>
                        </a>
                    </h1>
                </div>

                <!-- Language Dropdown -->
                <div class="col-2">
                    <ul class="list-unstyled">
                        <li class="nav-item dropdown" style="z-index: 1000">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-language"></i> {{ __('lang.abbr') }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('change.locale','pa') }}">
                                    {{ Settings::trans('Pashto', 'پښتو', 'پشتو') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('change.locale','da') }}">
                                    {{ Settings::trans('Dari', 'دري', 'دری') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('change.locale','en') }}">
                                    {{ Settings::trans('English', 'انګلیسي', 'انګلیسي') }}
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header><!-- #header -->



    <div class="main bg-light">
        <div class="container">
            @if($errors->any())
            <div class="alert alert-danger  mt-2" role="alert">
                <strong>{{ Settings::trans('Please', 'مهرباني وکړئ', 'لطفاً') }}</strong>
                {{ Settings::trans(' fill out the form correctly', 'دا فارم په سمه توګه ډکه کړئ.', 'این فارم را به درستی
                پر کنید') }}
            </div>
            @endif
            <x-backend.shared.alert.success />
        </div>
        <div>
            {{ $slot }}
        </div>
    </div>

    <!--==========================
      Footer
    ============================-->
    <footer id="footer" class="bg-light">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong>Ministry Of Higher Educations</strong>. All Rights Reserved
            </div>
        </div>
    </footer><!-- #footer -->

    @include('backend.layout.script')
    @yield('script')
    @stack('scripts')
    <script src="{{ asset('assets/frontend/js/sticky.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/easing.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/hoverIntent.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/superfish.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
    <script>
        // Function to check if the screen size is mobile
        function isMobileScreen() {
            return window.innerWidth <= 768; // Adjust the breakpoint as needed
        }
    
        // Function to update logo text based on screen size
        function updateLogoText() {
            var fullText = document.getElementById('full-text');
            var shortText = document.getElementById('short-text');
    
            if (isMobileScreen()) {
                fullText.style.display = 'none';
                shortText.style.display = 'inline'; // Show MOHE for mobile
            } else {
                fullText.style.display = 'inline';
                shortText.style.display = 'none';
            }
        }
    
        // Initial call to update logo text on page load
        updateLogoText();
    
        // Event listener for window resize to update logo text dynamically
        window.addEventListener('resize', function() {
            updateLogoText();
        });
    </script>



</body>

