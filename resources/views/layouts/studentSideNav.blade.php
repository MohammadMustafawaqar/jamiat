<ul class="app-menu">
    <li><a class="app-menu__item {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
            href="{{route('home')}}"><i class="app-menu__icon bi bi-speedometer"></i><span
                class="app-menu__label">{{__('lang.dashboard')}}</span></a>
    </li>
    <li><a class="app-menu__item {{ Str::startsWith(Route::currentRouteName(), 'topic.') ? 'active' : '' }}"
            href="{{route('topic.index')}}"><i class="app-menu__icon bi bi-file"></i><span
                class="app-menu__label">{{__('lang.topic_selection')}}</span></a>
    </li>
    <li><a class="app-menu__item {{ Str::startsWith(Route::currentRouteName(), 'thesis.') ? 'active' : '' }}"
            href="{{route('thesis.index')}}"><i class="app-menu__icon bi bi-file-earmark-text-fill"></i><span
                class="app-menu__label">{{__('lang.theses')}}</span></a>
    </li>
   
