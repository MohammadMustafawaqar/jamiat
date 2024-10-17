<ul class="app-menu">
    <li><a class="app-menu__item {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
            href="{{route('home')}}"><i class="app-menu__icon bi bi-speedometer"></i><span
                class="app-menu__label">{{__('lang.dashboard')}}</span></a>
    </li>
    @canany(['schools.create','schools.edit','schools.read','schools.delete'])
    <li><a class="app-menu__item {{ Str::startsWith(Route::currentRouteName(), 'schools.') ? 'active' : '' }}"
            href="{{route('schools.index')}}"><i class="app-menu__icon bi bi-houses"></i><span
                class="app-menu__label">{{__('lang.schools')}}</span></a>
    </li>
    @endcanany
    @canany(['students.create','students.edit','students.read','students.delete','students.show'])
    <li><a class="app-menu__item {{ Str::startsWith(Route::currentRouteName(), 'students.') ? 'active' : '' }}"
            href="{{route('students.index')}}"><i class="app-menu__icon bi bi-people"></i><span
                class="app-menu__label">{{__('lang.students')}}</span></a>
    </li>
    @endcanany
    <li><a class="app-menu__item {{ Str::startsWith(Route::currentRouteName(), 'topic.') ? 'active' : '' }}"
            href="{{route('topic.index')}}"><i class="app-menu__icon bi bi-card-checklist"></i><span
                class="app-menu__label">{{__('lang.topics')}}</span></a>
    </li>
    @canany(['supervisors.create','supervisors.edit','supervisors.read','supervisors.delete','supervisors.show'])
    <li><a class="app-menu__item {{ Str::startsWith(Route::currentRouteName(), 'supervisors.') ? 'active' : '' }}"
            href="{{route('supervisors.index')}}"><i class="app-menu__icon bi bi-person-check-fill"></i><span
                class="app-menu__label">{{__('lang.supervisors')}}</span></a>
    </li>
    @endcanany
    <li class="treeview {{ Str::contains(url()->current(), 'settings') ? 'is-expanded' : '' }}"><a
            class="app-menu__item" href="#" data-toggle="treeview"><i
                class="app-menu__icon bi bi-gear"></i><span
                class="app-menu__label">{{__('lang.setting')}}</span><i
                class="treeview-indicator bi bi-chevron-right"></i></a>
        <ul class="treeview-menu">
            @canany(['countries.create','countries.edit','countries.read','countries.delete','countries.show'])
            <li>
                <a class="treeview-item  {{ Str::startsWith(Route::currentRouteName(), 'country.') ? 'active' : '' }}"
                    href="{{route('country.index')}}"><i class="icon bi bi-arrow-return-{{(app()->getLocale()=='en')?'right':'left'}}"></i>
                    {{__('lang.countries')}}
                </a>
            </li>
            @endcanany
            @canany(['categories.create','categories.edit','categories.read','categories.delete','categories.show'])
            <li>
                <a class="treeview-item  {{ Str::startsWith(Route::currentRouteName(), 'category.') ? 'active' : '' }}"
                    href="{{route('category.index')}}"><i class="icon bi bi-arrow-return-{{(app()->getLocale()=='en')?'right':'left'}}"></i>
                    {{__('lang.categories')}}
                </a>
            </li>
            @endcanany
            <li>
                <a class="treeview-item  {{ Str::startsWith(Route::currentRouteName(), 'appreciation.') ? 'active' : '' }}"
                    href="{{route('appreciation.index')}}"><i class="icon bi bi-arrow-return-{{(app()->getLocale()=='en')?'right':'left'}}"></i>
                    {{__('lang.appreciation')}}
                </a>
            </li>
            <li>
                <a class="treeview-item  {{ Str::startsWith(Route::currentRouteName(), 'committee-member.') ? 'active' : '' }}"
                    href="{{route('committee-member.index')}}"><i class="icon bi bi-arrow-return-{{(app()->getLocale()=='en')?'right':'left'}}"></i>
                    {{__('lang.committee_member')}}
                </a>
            </li>
        </ul>
    </li>
</ul>