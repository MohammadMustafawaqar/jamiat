<ul class="app-menu">

    <li><a class="app-menu__item {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}"><i
                class="app-menu__icon bi bi-speedometer"></i><span
                class="app-menu__label">{{ __('lang.dashboard') }}</span></a>
    </li>

    @canany(['schools.create', 'schools.edit', 'schools.read', 'schools.delete'])
        <li>
            <a class="app-menu__item {{ Str::startsWith(Route::currentRouteName(), 'schools.') ? 'active' : '' }}"
                href="{{ route('schools.index') }}"><i class="app-menu__icon bi bi-houses"></i><span
                    class="app-menu__label">{{ __('lang.schools') }}</span>
            </a>
        </li>
    @endcanany
    @canany(['students.create', 'students.edit', 'students.read', 'students.delete', 'students.show', 'students.create', 'studentss.create.rajab', 'students.create.commission', 'students.create.evaluation', 'students.read.rajab', 'students.read.commission', 'students.read.evaluation'])
        <li class="treeview {{ Settings::check_parent_route(['students.', 'admin.student.']) }}">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-people"></i><span
                    class="app-menu__label">{{ __('lang.students') }}</span>
                <i class="treeview-indicator bi bi-chevron-right"></i></a>
            <ul class="treeview-menu">
                @canany(['students.create', 'students.create.rajab', 'students.create.commission', 'students.create.evaluation'])
                <li>
                    <a class="app-menu__item {{ Route::currentRouteName() == 'students.create' || Route::currentRouteName() == 'admin.student.form.second' ? 'active' : '' }}"
                        href="{{ route('students.create') }}"><i class="app-menu__icon bi bi-plus">
                        </i>
                        <span class="app-menu__label">{{ __('sidebar.add_students') }}</span>
                    </a>
                </li>
                @endcanany
                @canany(['students.read.commission', 'students.import', 'students.read'])
                <li>
                    <a class="app-menu__item {{ Settings::current_route('admin.student.form.commission') }}"
                        href="{{ route('admin.student.form.commission') }}"><i class="app-menu__icon bi bi-person-check">
                        </i>
                        <span class="app-menu__label">{{ __('sidebar.commission_students') }}</span>
                    </a>
                </li>
                @endcanany
                @canany(['students.read.evaluation', 'students.import', 'students.read'])
                <li>
                    <a class="app-menu__item {{ Settings::current_route('admin.student.form.evaluation')}}"
                        href="{{ route('admin.student.form.evaluation') }}"><i class="app-menu__icon bi bi-person-workspace">
                        </i>
                        <span class="app-menu__label">{{ __('sidebar.evaluation_students') }}</span>
                    </a>
                </li>
                @endcanany
                @canany(['students.read.rajab', 'students.import', 'students.read'])
                <li>
                    <a class="app-menu__item {{ Settings::current_route('admin.student.form.rajab') }}"
                        href="{{ route('admin.student.form.rajab') }}"><i class="app-menu__icon bi bi-person-square"></i><span
                            class="app-menu__label">{{ __('sidebar.rajab_students') }}</span>
                    </a>
                </li>
                @endcanany
            </ul>
        </li>
    @endcanany


    {{-- Exam --}}
    @canany(['exam.create', 'exam.edit', 'exam.read', 'exam.delete', 'exam.show'])
    <li>
        <a class="app-menu__item {{ Settings::current_route('admin.exam.') }}" href="{{ route('admin.exam.index') }}">
            <i class="app-menu__icon bi bi-clipboard-check"></i>
            <span class="app-menu__label">{{ __('sidebar.exams') }}</span></a>
    </li>
    @endcanany
    @canany(['supervisors.create', 'supervisors.edit', 'supervisors.read', 'supervisors.delete', 'supervisors.show'])
    <li class="treeview {{ Settings::check_parent_route(['supervisors.', 'topic.']) }}">
        <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-book"></i><span
                class="app-menu__label">{{ __('sidebar.publications') }}</span>
            <i class="treeview-indicator bi bi-chevron-right"></i></a>
        <ul class="treeview-menu">
            @canany(['topics.create', 'topics.edit', 'topics.read', 'topics.delete', 'topics.show'])
            <li>
                <a class="app-menu__item {{ Str::startsWith(Route::currentRouteName(), 'topic.') ? 'active' : '' }}"
                    href="{{ route('topic.index') }}">
                    <i class="app-menu__icon bi bi-card-checklist"></i>
                    <span class="app-menu__label">{{ __('lang.topics') }}</span>
                </a>
            </li>
            @endcanany
            @canany(['supervisors.create', 'supervisors.edit', 'supervisors.read', 'supervisors.delete',
                'supervisors.show'])
                <li><a class="app-menu__item {{ Str::startsWith(Route::currentRouteName(), 'supervisors.') ? 'active' : '' }}"
                        href="{{ route('supervisors.index') }}"><i class="app-menu__icon bi bi-person-check-fill"></i><span
                            class="app-menu__label">{{ __('lang.supervisors') }}</span></a>
                </li>
            @endcanany
        </ul>
    </li>
    @endcanany

    @canany(['countries.create', 'countries.edit', 'countries.read', 'countries.delete', 'countries.show', 'categories.create', 'categories.edit', 'categories.read', 'categories.delete', 'categories.show'])
    <li class="treeview {{ Str::contains(url()->current(), 'settings') ? 'is-expanded' : '' }}"><a
            class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-gear"></i><span
                class="app-menu__label">{{ __('lang.setting') }}</span><i
                class="treeview-indicator bi bi-chevron-right"></i></a>
        <ul class="treeview-menu">
            @canany(['countries.create', 'countries.edit', 'countries.read', 'countries.delete', 'countries.show'])
                <li>
                    <a class="treeview-item  {{ Str::startsWith(Route::currentRouteName(), 'country.') ? 'active' : '' }}"
                        href="{{ route('country.index') }}"><i
                            class="icon bi bi-arrow-return-{{ app()->getLocale() == 'en' ? 'right' : 'left' }}"></i>
                        {{ __('lang.countries') }}
                    </a>
                </li>
            @endcanany
            @canany(['categories.create', 'categories.edit', 'categories.read', 'categories.delete', 'categories.show'])
                <li>
                    <a class="treeview-item  {{ Str::startsWith(Route::currentRouteName(), 'category.') ? 'active' : '' }}"
                        href="{{ route('category.index') }}"><i
                            class="icon bi bi-arrow-return-{{ app()->getLocale() == 'en' ? 'right' : 'left' }}"></i>
                        {{ __('lang.categories') }}
                    </a>
                </li>
            @endcanany
            @canany(['appreciations.create', 'appreciations.edit', 'appreciations.read', 'appreciations.delete', 'appreciations.show'])
            <li>
                <a class="treeview-item  {{ Str::startsWith(Route::currentRouteName(), 'appreciation.') ? 'active' : '' }}"
                    href="{{ route('appreciation.index') }}"><i
                        class="icon bi bi-arrow-return-{{ app()->getLocale() == 'en' ? 'right' : 'left' }}"></i>
                    {{ __('lang.appreciation') }}
                </a>
            </li>
            @endcanany
            @canany(['committee_member.create', 'committee_member.edit', 'committee_member.read', 'committee_member.delete', 'committee_member.show'])
            <li>
                <a class="treeview-item  {{ Str::startsWith(Route::currentRouteName(), 'committee-member.') ? 'active' : '' }}"
                    href="{{ route('committee-member.index') }}"><i
                        class="icon bi bi-arrow-return-{{ app()->getLocale() == 'en' ? 'right' : 'left' }}"></i>
                    {{ __('lang.committee_member') }}
                </a>
            </li>
            @endcanany
            @canany(['school_grade.create', 'school_grade.edit', 'school_grade.read', 'school_grade.delete', 'school_grade.show'])
            <li>
                <a class="treeview-item  {{ Settings::current_route('admin.settings.jamiat_grades.') }}"
                    href="{{ route('admin.settings.jamiat_grades.index') }}"><i class="icon bi bi-bar-chart"></i>
                    {{ __('jamiat.jamiat_grade') }}
                </a>
            </li>
            @endcanany
            @canany(['education_level.create', 'education_level.edit', 'education_level.read', 'education_level.delete', 'education_level.show'])
            <li>
                <a class="treeview-item  {{ Settings::current_route('admin.settings.education-level.') }}"
                    href="{{ route('admin.settings.education-level.index') }}"><i class="icon bi bi-book"></i>
                    {{ __('sidebar.edu_level') }}
                </a>
            </li>
            @endcanany
            @canany(['language.create', 'language.edit', 'language.read', 'language.delete', 'language.show'])
            <li>
                <a class="treeview-item  {{ Settings::current_route('admin.settings.languages.') }}"
                    href="{{ route('admin.settings.languages.index') }}"><i class="icon bi bi-globe"></i>
                    {{ __('sidebar.languages') }}
                </a>
            </li>
            @endcanany

            @canany(['exam_centers.create', 'exam_centers.edit', 'exam_centers.read', 'exam_centers.delete', 'exam_centers.show'])
            <li>
                <a class="treeview-item  {{ Settings::current_route('admin.settings.campus.') }}"
                    href="{{ route('admin.settings.campus.index') }}">
                    <i class="icon bi bi-buildings"></i>
                    {{ __('sidebar.campuses') }}
                </a>
            </li>
            @endcanany
            @canany(['exam_centers.create', 'exam_centers.edit', 'exam_centers.read', 'exam_centers.delete', 'exam_centers.show'])
            <li>
                <a class="treeview-item  {{ Settings::current_route('admin.settings.user-group.') }}"
                    href="{{ route('admin.settings.user-group.index') }}">
                    <i class="icon bi bi-people"></i>
                    {{ __('sidebar.user_groups') }}
                </a>
            </li>
            @endcanany

        </ul>
    </li>
    @endcanany
</ul>
