<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if (app()->getLocale() !== 'en') dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    @if (app()->getLocale() == 'en')
    <link rel="stylesheet" href="{{asset('frontend/css/mdb.min.css')}}">
    @else
    <link rel="stylesheet" href="{{asset('frontend/css/mdb.rtl.min.css')}}">
    @endif
    <link rel="stylesheet" href="{{asset('admin/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/sweetalert/sweetalert2.min.css')}}">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @stack('styles')
    <style>
        * {
            font-family: "Amiri", serif;
            font-weight: 700;
            font-style: normal;
        }
    </style>
</head>

<body style="background-color: #f1f1f1;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <!-- Container wrapper -->
        <div class="container">
            <!-- Toggle button -->
            <button data-mdb-collapse-init class="navbar-toggler" type="button"
                data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Navbar brand -->
                <a class="navbar-brand mt-2 mt-lg-0" href="{{route('home')}}">
                    {{__('lang.directorate')}}
                </a>
                <!-- Left links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}">{{__('lang.home')}}</a>
                    </li>
                </ul>
                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->

            <!-- Right elements -->
            <div class="d-flex align-items-center">
                <!-- Languages -->
                <div class="dropdown">
                    <a data-mdb-dropdown-init
                        class="text-light me-3 dropdown-toggle hidden-arrow" href="#"
                        id="navbarDropdownMenuLink" role="button" aria-expanded="false">
                        <i class="fa-solid fa-language" style="font-size: 1.5em"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="{{ route('change-language', 'en') }}">English</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('change-language', 'ps') }}">پښتو</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('change-language', 'fa') }}">دری</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('change-language', 'ar') }}">عربی</a>
                        </li>
                    </ul>
                </div>
                <!-- Notifications -->
                <div class="dropdown">
                    <a data-mdb-dropdown-init
                        class="text-light me-3 dropdown-toggle hidden-arrow" href="#"
                        id="navbarDropdownMenuLink" role="button" aria-expanded="false">
                        <i class="fas fa-bell"  style="font-size: 1.4em"></i>
                        <span class="badge rounded-pill badge-notification bg-danger">1</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="#">Some news</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Another news</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </li>
                    </ul>
                </div>
                <!-- Avatar -->
                <div class="dropdown">
                    <a data-mdb-dropdown-init class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                        id="navbarDropdownMenuAvatar" role="button" aria-expanded="false">
                        <img src="{{App\Models\Student::where('user_id',Auth::id())->first()->image_path}}"
                            class="rounded-circle" height="30" style="border: 2px solid white;"
                            alt="Black and White Portrait of a Man" loading="lazy" />
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                        <li>
                            <a class="dropdown-item" style="text-align: right" href="{{ route('student.profile') }}">
                                <i class="bi bi-person-circle me-2 fs-5"></i> {{__('lang.profile')}}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" style="text-align: right" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-left me-2 fs-5"></i> {{ __('lang.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Right elements -->
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    <main style="min-height: 86vh;margin-top:20px;">
        <div class="container">
            @yield('content')
        </div>
    </main>
    <form id="frm_delete" method="POST">
        @csrf
        @method('DELETE')
    </form>
    <footer class="bg-body-tertiary text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Copyright:
            <a class="text-body" href="https://mohe.gov.af/">MOHE</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Essential javascripts for application to work-->
    <script src="{{asset('admin/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('frontend/js/mdb.umd.min.js')}}"></script>
    <script src="{{asset('admin/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('admin/sweetalert/sweetalert2.all.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/plugins/printThis.js')}}"></script>

    <!-- Page specific javascripts-->
    @stack('scripts')

    <script>
        $(".spinner-border").css("visibility", "hidden");
        $(document).ajaxStart(function() {
            $(".spinner-border").css("visibility", "visible");
        });
        $(document).ajaxComplete(function() {
            $(".spinner-border").css("visibility", "hidden");
        });
        @if (session()->has('msg'))
            toastr.success("{{ session()->get('msg') }}", "{{__('lang.notice')}}")
        @endif
        @if (session()->has('error'))
            toastr.error("{{ session()->get('error') }}", "{{__('lang.error')}}")
        @endif
        $("#btn_print").click(function(){
            $('.printDiv').printThis();
        })

        $(document).on("click",".btn-delete",function(){
            var deleteRoute=$(this).attr('route');
            Swal.fire({
                title: "{{__('messages.confirm_delete')}}",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{__('lang.delete')}}",
                cancelButtonText: "{{__('lang.cancel')}}"
                }).then((result) => {
                if (result.isConfirmed) {
                    $("#frm_delete").attr('action',deleteRoute);
                    $("#frm_delete").submit();
                }
            });
        })
    </script>
</body>

</html>