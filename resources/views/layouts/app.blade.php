<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if (app()->getLocale() !== 'en') dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    <link rel="stylesheet" href="{{asset('admin/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/sweetalert/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    @stack('styles')
    <style>
        * {
            font-family: "Amiri", serif;
            font-weight: 800;
            font-style: normal;
        }

        #nprogress .bar {
            background: #29d;
            /* Custom color */
        }

        #nprogress .spinner-icon {
            border-top-color: #29d;
            /* Custom color */
            border-left-color: #29d;
            /* Custom color */
        }

        .text-lg {
            font-size: 1.5em;
        }
    </style>
</head>

<body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="{{route('home')}}">MOHE</a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
            aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            {{-- <li class="app-search">
                <input class="app-search__input" type="search" placeholder="Search">
                <button class="app-search__button"><i class="bi bi-search"></i></button>
            </li> --}}
            <!--Notification Menu-->
            <li class="dropdown"><a class="app-nav__item animate__animated animate__swing" href="#"
                    data-bs-toggle="dropdown" aria-label="Show notifications"><i class="bi bi-bell fs-5"></i></a>
                <ul class="app-notification dropdown-menu dropdown-menu-right">
                    <li class="app-notification__title">You have 4 new notifications.</li>
                    <div class="app-notification__content">
                        <li><a class="app-notification__item" href="javascript:;"><span
                                    class="app-notification__icon"><i
                                        class="bi bi-envelope fs-4 text-primary"></i></span>
                                <div>
                                    <p class="app-notification__message">Lisa sent you a mail</p>
                                    <p class="app-notification__meta">2 min ago</p>
                                </div>
                            </a></li>
                    </div>
                    <li class="app-notification__footer"><a href="#">See all notifications.</a></li>
                </ul>
            </li>
            <!-- Language Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-bs-toggle="dropdown"
                    aria-label="Open Profile Menu"><i class="bi bi-translate fs-4"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('change-language', 'en') }}">English</a>
                    <a class="dropdown-item" href="{{ route('change-language', 'ps') }}">پښتو</a>
                    <a class="dropdown-item" href="{{ route('change-language', 'fa') }}">دری</a>
                    <a class="dropdown-item" href="{{ route('change-language', 'ar') }}">عربی</a>
                </ul>
            </li>
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-bs-toggle="dropdown"
                    aria-label="Open Profile Menu"><i class="bi bi-person fs-4"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" @if(app()->getLocale()!='en')style="text-align: right"@endif
                            href="{{route('user.setting')}}"><i class="bi bi-gear me-2 fs-5"></i>
                            {{__('lang.change_password')}}</a>
                    </li>
                    @if(auth()->user()->user_type=='Admin')
                    {{-- @canany(['users.create', 'users.read', 'users.edit']) --}}
                    <li><a class="dropdown-item" @if(app()->getLocale()!='en')style="text-align: right"@endif
                            href="{{route('user.index')}}"><i class="bi bi-people me-2 fs-5"></i>
                            {{__('lang.users')}}</a>
                    </li>
                    {{-- @endcanany
                    @can('users.db_backup') --}}
                    <li><a class="dropdown-item" @if(app()->getLocale()!='en')style="text-align: right"@endif
                            href="{{route('backup.database')}}"><i class="bi bi-layer-backward me-2 fs-5"></i>
                            {{__('lang.take_db_backup')}}</a>
                    </li>
                    {{-- @endcan
                    @can('users.file_backup') --}}
                    <li><a class="dropdown-item" @if(app()->getLocale()!='en')style="text-align: right"@endif
                            href="{{route('backup.download')}}"><i class="bi bi-cloud-download-fill me-2 fs-5"></i>
                            {{__('lang.download_files_backup')}}</a>
                    </li>
                    {{-- @endcan --}}
                    @endif
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
            </li>
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{asset('logo.png')}}"
                alt="User Image">
            <div>
                <p class="app-sidebar__user-name">{{auth()->user()->name}}</p>
                <p class="app-sidebar__user-designation">{{auth()->user()->user_type}}</p>
            </div>
        </div>
        @if (auth()->user()->user_type=="Admin")
        @include('layouts.adminSideNav')
        @elseif(auth()->user()->user_type=="Supervisor")
        @include('layouts.supervisorSideNav')
        @else
        @include('layouts.studentSideNav')
        @endif
    </aside>
    <main class="app-content">
        @yield('content')
    </main>

    <form id="frm_delete" method="POST">
        @csrf
        @method('DELETE')
    </form>
    <!-- Essential javascripts for application to work-->
    <script src="{{asset('admin/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('admin/js/main.js')}}"></script>
    <script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('admin/sweetalert/sweetalert2.all.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/plugins/printThis.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>

    <!-- Page specific javascripts-->
    @stack('scripts')

    <script>
        $(document).ready(function() {
            $("form").submit(function() {
                $(this).find(":submit").attr("disabled", "disabled");
                var txt=$(this).find(":submit").text();
                $(this).find(":submit").html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">${txt}</span>`);
            });
        });
        NProgress.configure({ showSpinner: true });
        $(document).ajaxStart(function() {
            NProgress.start();
        });
        $(document).ajaxStop(function() {
            NProgress.done();
        });
        window.addEventListener('beforeunload', function() {
            NProgress.start();
        });
        $(".pagination").attr('dir','ltr');
        @if(app()->getLocale()!="en")
        $("th").addClass('text-end');
        @endif
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "timeOut": "4000",
            "extendedTimeOut": "1000",
            "closeButton": true,
            "progressBar": true
        };
        @if (session()->has('msg'))
            toastr.success("{{ session()->get('msg') }}", "{{__('lang.notice')}}")
        @endif
        @if (session()->has('error'))
            toastr.error("{{ session()->get('error') }}", "{{__('lang.error')}}")
        @endif
        $("#btnPrint").click(function(){
            $('.printDiv').printThis();
        })


        //global delete action
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