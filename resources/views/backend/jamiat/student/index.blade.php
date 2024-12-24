<x-app :title="__('lang.students')">

    <x-page-nav :title="__('lang.students')" icon='users'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>
        <li class="breadcrumb-item">{{ __('lang.students') }}</li>
        <li class="breadcrumb-item">{{ __('lang.students') }}</li>
    </x-page-nav>
    <x-page-container>
        <div class="container-fluid">
            <div class="">
                <div class="btn-group" dir="ltr">
                    @can('students.import')
                        <button class="btn btn-success" onclick="openImportModal()">
                            <i class="fa fa-file-excel"></i>
                            {{ __('jamiat.excel_import_btn') }}
                        </button>
                    @endcan
                    <button class="btn btn-sm btn-info" id="btn-filter" title='filter'>
                        <i class="fa fa-search"></i>
                    </button>
                    <a href="{{ route('admin.student.evaluation.export') }}" class="btn btn-sm btn-secondary"
                        title='export'>
                        <i class="fa fa-download"></i>
                    </a>
                    <br>
                </div>
            </div>
            <div class="row">
                <form class="row" action="{{ route('admin.student.form.evaluation') }}" id='filter-container'
                    style="{{ request()->except('perPage', 'page') ? '' : 'display: none' }}">
                    @foreach (request()->only('perPage') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <x-input2 type="text" name='form_id' :label="__('lang.form_id')" col='col-sm-2' />
                    <x-input2 type="text" name='filter_name' :label="__('jamiat.name')" col='col-sm-2' />
                    <x-input2 type="text" name='tazkira_no' :label="__('jamiat.tazkira_no')" col='col-sm-2' />

                    <x-select2 col="col-sm-2" :list="App\Models\AddressType::get()" id='filter_address_type_id' text="name"
                        value='id' name="filter_address_type_id" :label="__('lang.address_type')" />

                    <x-select2 :list="App\Models\School::with('province')->get()" id='school_id' name="school_id" :label="__('jamiat.school_name')" col="col-sm-4"
                        text='name' value='id' concat_model='province' concat_field="name" />

                    <x-input2 type="text" name='phone' :label="__('lang.phone')" col='col-sm-2' />


                    <x-select2 :list="App\Models\Province::get()" id='filter_province_id' name="filter_province_id" :label="__('lang.province')"
                        col="col-sm-2" text='name' value='id' />


                    <x-select2 :list="App\Models\Appreciation::get()" id='appreciation_id' name="appreciation_id" :label="__('lang.appreciation')"
                        col="col-sm-2" text='name' value='id' />

                    <x-select2 :list="App\Models\UserGroup::get()" id='user_group_id' name="user_group_id" :label="__('sidebar.user_groups')"
                        col="col-sm-2" text='name' value='id' />

                    <x-select2 :list="App\Models\User::get()" id='user_id' name="user_id" :label="__('lang.user')" col="col-sm-2"
                        text='name' value='id' />


                    <div class="col-sm-2 mt-4">
                        <div class="btn-group" dir="ltr">
                            <x-btn-filter type='submit' />
                            <x-btn-reset :route="route(Route::currentRouteName())" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong> {{ session('error') }}</strong>
                @if(session('download_link'))
                <a
                    href="{{ route('admin.school.download.invalid.excel', [
                        'file_name' => session('download_link'),
                        'locale' => '',
                    ]) }}">
                    {{ __('jamiat.invalid_file_download') }}
                </a>
                @endif
            </div>
        @endif
        <x-table>
            <x-slot:tools>
                <div></div>
                <div class="btn-group" dir="ltr">
                    <button type="submit" class="btn btn-primary" style="display: none" id="generate-id-cards-btn">
                        {{ __('jamiat.generate_card_btn') }}
                    </button>

                    <button type="submit" class="btn btn-success" style="display: none" id="add-score-btn">
                        {{ __('jamiat.add_scores') }}
                    </button>

                    <button type="submit" class="btn btn-secondary" style="display: none" id="print-diploma-btn">
                        {{ __('jamiat.print_diploma') }}
                    </button>

                </div>


            </x-slot:tools>
            <thead class="table-primary">
                <tr>
                    <th><input type="checkbox" id="select-all"></th>

                    <th>#</th>
                    {{-- <th>{{__('lang.image')}}</th> --}}
                    <th>{{ __('lang.form_id') }}</th>
                    <th>{{ __('lang.name') }}</th>
                    <th>{{ __('lang.father_name') }}</th>
                    <th>{{ __('jamiat.tazkira_no') }}</th>
                    {{-- <th>{{ __('lang.dob_qamari') }}</th> --}}
                    <th>{{ __('jamiat.address') }}</th>
                    {{-- <th>{{ __('lang.permanent_address') }}</th> --}}
                    <th>{{ __('lang.phone') }}</th>
                    <th>{{ __('lang.school') }}</th>
                    <th>{{ __('lang.graduation_year') }}</th>
                    <th>{{ __('lang.appreciation') }}</th>
                    <th>{{ __('jamiat.exam') }}</th>
                    <th>{{ __('lang.status') }}</th>
                    <th>{{ __('lang.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>
                            <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                class="student-checkbox">
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->form_id }}</td>
                        {{-- <td>
                                    <img src="{{$student->image_path}}" alt="Student image" height="70">
                                </td> --}}
                        <td>{{ $student->full_name }}</td>
                        <td>{{ $student->father_name }}</td>
                        <td>{{ $student->tazkira?->tazkira_no }}</td>
                        {{-- <td>{{ $student->dob_qamari }}</td> --}}
                        <td>

                            <div>
                                <div class="text-truncate" style="max-width: 100px;" data-toggle="tooltip"
                                    data-placement="top"
                                    title="{{ __('lang.current_address') }}: {{ $student->currentAddress }}">
                                    {{ $student->currentAddress }}

                                </div>
                                <div class="text-truncate" style="max-width: 100px;" data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="{{ __('lang.permanent_address') }}: {{ $student->permanentAddress }}">
                                    {{ $student->permanentAddress }}
                                </div>
                            </div>
                        </td>

                        <td dir="ltr">
                            @if ($student->whatsapp != $student->phone)
                                <div>
                                    {{ $student->phone }}
                                </div>
                                <div>
                                    {{ $student->whatsapp }}
                                </div>
                            @else
                                {{ $student->phone }}
                            @endif
                        </td>
                        <td data-toggle="tooltip" data-placement="bottom"
                            title="{{ $student->school?->name }} ({{ $student->school?->address }})">
                            <div class="text-truncate" style="max-width: 150px;">
                                {{ $student->school?->name }}
                            </div>
                            <div>
                                ({{ $student->school?->address }})
                            </div>
                        </td>
                        <td>{{ $student->graduation_year }}</td>
                        <td>
                            <div data-toggle="tooltip" data-placement="bottom"
                            title="{{ __('jamiat.school_appreciation') }}: {{ $student->appreciation?->name }}">
                                {!! JamiaHelper::studentAppreciationBadge($student->appreciation) !!}
                            </div>
                            <div data-toggle="tooltip" data-placement="bottom"
                            title="{{ __('jamiat.exam_appreciation') }}: {{ $student->studentExams?->first()?->appreciation?->name }}">
                                {!! JamiaHelper::studentAppreciationBadge($student->studentExams?->first()?->appreciation) !!}
                            </div>
                        </td>
                        <td class="text-truncate" style="max-width: 100px;" data-toggle="tooltip"
                            data-placement="bottom" title="{{ $student->exams->first()?->title }}">
                            {{ $student->exams->first()?->title }}
                        </td>
                        <td>
                            {!! JamiaHelper::studentExamStatus($student->studentExams?->first()?->status) !!}

                        </td>
                        <td>
                            <div class="btn-group" dir="ltr">
                                @can('students.delete')
                                    <x-buttons.delete :route="route('students.destroy', $student)" />
                                @endcan
                                @can('students.show')
                                    <x-buttons.show :route="route('admin.student.show', $student)" />
                                @endcan
                                @can('students.edit')
                                    <x-buttons.edit :route="route('students.edit', $student)" />
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <x-slot:links>
                <!-- Paginate Links -->
                {{ $students->links() }}

            </x-slot:links>
        </x-table>
    </x-page-container>
    <div class="modal-containers">
        @can('students.import')
            <x-modal id='import-modal' :title="__('jamiat.import_from_excel')" size='md'>
                <div class="container-fluid">
                    <form id='import-form' action="{{ route('admin.student.import.excel') }}" class="row"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="form_type"
                            value="{{ Route::currentRouteName() == route('admin.student.form.evaluation') ? 'evaluation' : 'commission' }}">

                        <div class="form-group ">
                            <label class='form-label fs-6 '>{{ __('lang.address_type') }}:</label>
                            <div class="">
                                <input class="btn-check" type="radio" name="address_type_id" id="interior"
                                    value="1" checked>
                                <label class="btn btn-outline-primary" for="interior">
                                    {{ __('jamiat.interior') }}
                                </label>

                                <input class="btn-check" type="radio" name="address_type_id" id="exterior"
                                    value="2">
                                <label class="btn btn-outline-primary" for="exterior">
                                    {{ __('jamiat.exterior') }}
                                </label>
                            </div>
                        </div>

                        <x-js-select2 :list="JamiaHelper::exams()" :label="__('jamiat.select_exam')" value='id' text='title' id='exam_id'
                            modal_id='import-modal' name='exam_id' col='col-sm-12 fs-6' class="select2"
                            :required="1" />
                        <x-input type="file" name='excel_file' col='col-12 fs-6' :label="__('jamiat.select_excel_file')"
                            :required="1" />

                        <div class="d-flex justify-content-between bg-light mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                {{ Settings::trans('Close', 'بند کړئ', 'لغوه') }}</button>
                            <x-btn-save type='button' id='save-btn' />
                        </div>
                    </form>
                </div>
            </x-modal>
        @endcan
        <x-modal id='card-modal' :title="__('jamiat.generate_card_btn')" size='md'>
            <div class="container-fluid">

                <form action="{{ route('admin.student.generate.card') }}" method="POST" id='card-form'>
                    <x-js-select2 :list="$exams" :label="__('jamiat.exam')" value='id' text='title'
                        id='card_exam_id' name='exam_id' col='col-sm-12' modal_id='card-modal' />
                    @csrf
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-save"></i>
                    </button>
                </form>

            </div>
        </x-modal>

        <x-modal id='scores-modal' :title="__('jamiat.add_scores')" size='md'>
            <div class="container-fluid">

                <form action="{{ route('admin.student.scores.many.create') }}" method="GET" id='scores-form'>
                    <x-js-select2 :list="$exams" :label="__('jamiat.exam')" value='id' text='title'
                        id='card_exam_id' name='exam_id' col='col-sm-12' modal_id='card-modal' />
                    @csrf
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-save"></i>
                    </button>
                </form>

            </div>
        </x-modal>

        <x-modal id='diploma-modal' :title="__('jamiat.print_diploma')" size='md'>
            <div class="container-fluid">

                <form action="{{ route('admin.student.diploma.store') }}" method="POST" id='diploma-form'>
                    <x-js-select2 :list="$exams" :label="__('jamiat.exam')" value='id' text='title'
                        id='diploma_exam_id' name='exam_id' col='col-sm-12' modal_id='diploma-modal' />
                    @csrf
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-save"></i>
                    </button>
                </form>

            </div>
        </x-modal>

    </div>
    @push('scripts')
        <script>
            function openImportModal() {
                $("#import-modal").modal('show');
            }



            // Card Generation Handling Start

            function toggleGenerateButton() {
                const isAnyChecked = $('.student-checkbox:checked').length > 0;
                $('#generate-id-cards-btn').toggle(isAnyChecked);
                $('#add-score-btn').toggle(isAnyChecked);
                $('#print-diploma-btn').toggle(isAnyChecked);

            }

            $('#add-score-btn').on('click', function() {
                const selectedIds = $('.student-checkbox:checked').map(function() {
                    return this.value;
                }).get();

                if (selectedIds.length === 0) {
                    alert("Please select at least one student.");
                    return;
                }

                // Clear any existing hidden inputs to avoid duplicates
                $('#scores-form input[name="student_ids[]"]').remove();

                // Add new hidden inputs for selected students
                selectedIds.forEach(function(id) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'student_ids[]',
                        value: id
                    }).appendTo('#scores-form');
                });

                $('#scores-modal').modal('show');
            });

            $('#print-diploma-btn').on('click', function() {
                const selectedIds = $('.student-checkbox:checked').map(function() {
                    return this.value;
                }).get();

                if (selectedIds.length === 0) {
                    alert("Please select at least one student.");
                    return;
                }

                // Clear any existing hidden inputs to avoid duplicates
                $('#diploma-form input[name="student_ids[]"]').remove();

                // Add new hidden inputs for selected students
                selectedIds.forEach(function(id) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'student_ids[]',
                        value: id
                    }).appendTo('#diploma-form');
                });

                $('#diploma-modal').modal('show');
            });

            // Call toggleGenerateButton on page load and on checkbox changes
            $(document).ready(function() {
                toggleGenerateButton();

                $("#btn-filter").click(function() {
                    $("#filter-container").toggle();
                });
                $("input[name='address_type_id']").change(function() {
                    if ($("#interior").is(":checked")) {
                        $("#country_container").hide();
                    } else if ($("#exterior").is(":checked")) {
                        $("#country_container").show();
                        $("#village").attr('col', 'col-sm-6')
                    }
                });
            });

            $('#select-all').on('change', function() {
                $('.student-checkbox').prop('checked', $(this).is(':checked'));
                toggleGenerateButton();
            });

            $('.student-checkbox').on('change', function() {
                toggleGenerateButton();
            });

            // Open modal and gather selected IDs
            $('#generate-id-cards-btn').on('click', function() {
                const selectedIds = $('.student-checkbox:checked').map(function() {
                    return this.value;
                }).get();

                if (selectedIds.length === 0) {
                    alert("Please select at least one student.");
                    return;
                }

                // Clear any existing hidden inputs to avoid duplicates
                $('#card-form input[name="student_ids[]"]').remove();


                selectedIds.forEach(function(id) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'student_ids[]',
                        value: id
                    }).appendTo('#card-form');
                });

                $('#card-modal').data('selected-ids', selectedIds);
                $('#card-modal').modal('show');
            });

            $("#filter_country_id").change(function() {
                const country_id = $("#filter_country_id").val()
                loadProvinces(country_id, 'filter_province_id');
            });

            $("#filter_province_id").change(function() {
                const province_id = $("#filter_province_id").val()
                loadDistricts(province_id, 'filter_district_id');
            });

            $("#user_group_id").change(function() {
                const province_id = $("#user_group_id").val()
                loadGroupUsers("{{ route('load-group-users') }}", 'province_id', province_id, 'user_id');
            });

            $("#filter_address_type_id").change(function() {
                const address_type_id = $("#filter_address_type_id").val()
                loadGroupUsers("{{ route('load-school-by-address') }}", 'address_type_id', address_type_id,
                    'school_id');
            });





            function loadProvinces(country_id, target_el_id) {
                $.ajax({
                    url: "{{ route('load-provinces') }}",
                    method: 'GET',
                    data: {
                        'country_id': country_id,
                    },
                    success: function(response) {
                        $("#" + target_el_id).html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function loadDistricts(province_id, target_el_id) {
                $.ajax({
                    url: "{{ route('load-districts') }}",
                    method: 'GET',
                    data: {
                        'province_id': province_id,
                    },
                    success: function(response) {

                        $("#" + target_el_id).html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function loadGroupUsers(routeUrl, param_name, param_value, target_el_id) {

                $.ajax({
                    url: routeUrl,
                    method: 'GET',
                    data: {
                        [param_name]: param_value,
                    },
                    success: function(response) {
                        console.log(response)
                        $("#" + target_el_id).html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        </script>
    @endpush
</x-app>
