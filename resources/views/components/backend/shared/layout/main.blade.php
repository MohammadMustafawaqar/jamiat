@props([
    'title' => 'title'
])
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if (app()->getLocale() !== 'en') dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }} ">
    <link rel="shortcut icon" href="{{ asset('favicon.ico')}} " type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }} - {{ $title }}</title>
    
    
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    @include('components.backend.shared.layout.partials.styles')
    @stack('styles')
    <style>
        * {
            font-family: "Amiri", serif;

            font-weight: 800;
            font-style: normal;
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
                <ul class="app-notification dropdown-menu dropdown-menu-right" style="z-index: 10000000;">
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
                    <a class="dropdown-item" href="{{ route('change-language', 'dr') }}">دری</a>
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
                    <li>
                        <a class="dropdown-item" @if(app()->getLocale()!='en')style="text-align: right"@endif href="{{
                            route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-{{(app()->getLocale()=='en')?'right':'left'}} me-2 fs-5"></i> {{
                            __('lang.logout') }}
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
        @include('layouts.adminSideNav')
    </aside>
    <main class="app-content">
        {{ $slot }}
    </main>

    <form id="frm_delete" method="POST">
        @csrf
        @method('DELETE')
    </form>
    <!-- Essential javascripts for application to work-->
   
    @include('components.backend.shared.layout.partials.scripts')


    <!-- Page specific javascripts-->
    @stack('scripts')

</body>

</html>