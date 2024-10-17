<ul class="app-menu">
    <li><a class="app-menu__item {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
            href="{{route('home')}}"><i class="app-menu__icon bi bi-speedometer"></i><span
                class="app-menu__label">{{__('lang.dashboard')}}</span></a>
    </li>
    <li><a class="app-menu__item {{ Route::currentRouteName() == 'all-students' ? 'active' : '' }}"
            href="{{route('all-students')}}"><i class="app-menu__icon bi bi-people"></i><span
                class="app-menu__label">{{__('lang.students')}}</span></a>
    </li>
</ul>