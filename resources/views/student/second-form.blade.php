<x-app :title="__('sidebar.add_students')">
    <x-page-nav :title="__('sidebar.add_students')" icon='add'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>

        <li class="breadcrumb-item"><a href="{{ route('admin.student.form.commission') }}">{{ __('lang.students') }}</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('students.create') }}">{{ __('lang.first_form') }}</a></li>
        <li class="breadcrumb-item"><span>{{ __('lang.new_student') }}</span></li>
    </x-page-nav>

    <div class="container-fluid" style="min-height: 70vh">
        <div class="row" id='form-container'>
            <div class="col-lg-12">
                <div class="tile">
                    <div class="tile-title-w-btn">
                        <h3 class="title"><i class="bi bi-plus"></i> {{ __('lang.new_student') }}</h3>
                        <a class="btn btn-primary" href="{{ route('students.index') }}"><i
                                class='bi bi-list-ul'></i></a>
                    </div>
                    <div class="tile-body">
                        <form action="{{ route('students.store') }}" method="post">
                            @csrf
                            <div class="row">
                                @if ($errors->any())
                                    @foreach ($errors->all() as $err)
                                        <p class="text-danger">{{ $err }}</p>
                                    @endforeach
                                @endif

                                <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="form_id" :label="__('lang.form_id')"
                                    :required="1" autofocus />
                                <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="name" :label="__('lang.name')"
                                    :required="1" />
                                {{-- <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="name_en" :label="__('lang.name_en')"
                                    :required="1" /> --}}
                                <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="last_name" :label="__('lang.last_name')"
                                    :required="1" />
                                {{-- <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="last_name_en" :label="__('lang.last_name_en')"
                                    :required="1" /> --}}
                                <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="father_name" :label="__('lang.father_name')"
                                    :required="1" />
                                {{-- <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="father_name_en" :label="__('lang.father_name_en')"
                                    :required="1" /> --}}
                                <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="grand_father_name"
                                    :label="__('lang.grand_father_name')" :required="1" />
                                {{-- <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="grand_father_name_en"
                                    :label="__('lang.grand_father_name_en')" :required="1" /> --}}
                                <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" display="name_ps" :options="$genders"
                                    name="gender_id" :label="__('lang.gender')" :required="1" />

                                <x-qamari-input name='dob_qamari' id='dob_qamari' :label="__('lang.dob_qamari')" format="yyyy/mm/dd"
                                    col='col-6 col-md-4 col-lg-3 col-xl-2' :required="1" />

                                @if ($selections['form_type'] == 3)
                                    <x-input type='date' col="col-6 col-md-4 col-lg-3 col-xl-2" name="dob"
                                        :label="__('lang.dob')" :required="1" />

                                    <x-date-picker col="col-12 col-md-4 col-lg-3 col-xl-2" name="dob_shamsi"
                                        :label="__('lang.dob_shamsi')" id='dob_shamsi' :required="1" />
                                @endif

                                <x-select2 col="col-6 col-md-4 col-lg-3 col-xl-2" :list="$nic_types" name="tazkira_type"
                                    value='value' text='text' :label="__('jamiat.nic_type')" selected_value='electric'
                                    :required='1'
                                    />

                                <x-input type='text' name='tazkira_no' :label="__('jamiat.tazkira_no')"
                                    col='col-6 col-md-4 col-lg-3 col-xl-2' :required='1' />

                                @if ($selections['form_type'] != 3)
                                    <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" :options="JamiaHelper::educationLevels()"
                                        :display="Settings::trans('en_name', 'pa_name', 'da_name', 'ar_name')" name="education_level_id" :label="__('jamiat.edu_level')"
                                        :required="1" class='select2' />

                                    <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" :options="JamiaHelper::Languages()"
                                        :display="Settings::trans('en_name', 'pa_name', 'da_name', 'ar_name')" name="language_id" :label="__('jamiat.mother_tongue')"
                                        :required="1" class='select2' />
                                @endif

                                <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="phone" :label="__('lang.phone')"
                                    :required="1" selected_value='electric' />

                                @if ($selections['form_type'] != 3)
                                    <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="whatsapp" :label="__('lang.whatsapp')"
                                        :required="1" />

                                    <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="relative_contact"
                                        :label="__('jamiat.relative_contact')"  />

                                    <x-input type="file" col="col-6 col-md-4 col-lg-3 col-xl-2" name="image_path"
                                        :label="__('lang.image')"  />
                                @endif



                                @if ($selections['form_type'] != 3)
                                    {{-- <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="$categories"
                                        name="category_id" :label="__('lang.category')" :required="1" />
                                    <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="old('category_id')
                                        ? App\Models\Category::find(old('category_id'))->subCategories
                                        : collect()"
                                        name="sub_category_id" :label="__('lang.sub_category')" :required="1" /> --}}
                                @endif

                                <div class="col-12">
                                    <hr />
                                   <div class="row">
                                    <h4 class="col-4">{{ __('lang.school') }}</h4>
                                    <x-checkbox col='col-sm-2' name='new_school' id='new_school' :label="__('jamiat.new_school')" value='true' />
                                   </div>
                                </div>

                                <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="$countries"
                                    name="school_country_id" :label="__('lang.country')" :required="1" :selected="old('school_country_id', 1)" />
                                <!-- Ensure selected country -->

                                <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="old('school_country_id')
                                    ? App\Models\Country::find(old('school_country_id'))->provinces
                                    : App\Models\Country::find(1)->provinces"
                                    name="school_province_id" :label="__('lang.province')" :required="1"
                                    :selected="old('school_province_id')" />

                                <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="old('school_province_id')
                                    ? App\Models\Province::find(old('school_province_id'))->districts
                                    : collect()"
                                    id='school_district_id'
                                    name="school_district_id" :label="__('lang.district')" :required="1"
                                    :selected="old('school_district_id')" />


                                <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" id="school_id" :options="old('school_district_id')
                                    ? App\Models\District::find(old('school_district_id'))->schools
                                    : collect()"
                                    name="school_id" :label="__('lang.school')" :required="1" :selected="old('school_id')" />


                                @if ($selections['form_type'] != 3)
                                    <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="graduation_year"
                                        :label="__('lang.graduation_year')" :required="1" />

                                    <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" :options="$appreciations"
                                        name="appreciation_id" :label="__('lang.appreciation')" :required="1" class='select2' />
                                @endif

                                <div class="col-12">
                                    <hr />
                                    <h4>{{ __('lang.current_address') }}</h4>
                                </div>

                                <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="$countries"
                                    name="current_country_id" :label="__('lang.country')" :required="1"
                                    :selected="1" />
                                <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="old('current_country_id')
                                    ? App\Models\Country::find(old('current_country_id'))->provinces
                                    : App\Models\Country::find(1)->provinces"
                                    name="current_province_id" :label="__('lang.province')" :required="1" />
                                <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="old('current_province_id')
                                    ? App\Models\Province::find(old('current_province_id'))->districts
                                    : collect()"
                                    name="current_district_id" :label="__('lang.district')" :required="1" />
                                <x-input col="col-6 col-md-4 col-lg-3" name="current_village" :label="__('lang.village')"
                                    :required="1" />

                                <div class="col-12">
                                    <hr />
                                    <h4>{{ __('lang.permanent_address') }}</h4>
                                </div>

                                <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="App\Models\Country::find(1)->provinces"
                                    name="permanent_province_id" :label="__('lang.province')" :required="1" />
                                <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="old('permanent_province_id')
                                    ? App\Models\Province::find(old('permanent_province_id'))->districts
                                    : collect()"
                                    name="permanent_district_id" :label="__('lang.district')" :required="1" />
                                <x-input col="col-6 col-md-4 col-lg-3" name="permanent_village" :label="__('lang.village')"
                                    :required="1" />
                                {{-- <div class="col-6">
                                    <input type="text" id="qamari-date" value="yyyy-mm-dd">
                                    <div id="error-message" style="color:red;"></div>
                                </div> --}}



                            </div>
                            <div class="d-flex justify-content-between bg-light p-3">
                                <x-btn-back route="students.create" />

                                <div>
                                    <button class="btn btn-info" type='submit' name='action'
                                        value='save_continue'>
                                        <i class="fa-regular fa-save"></i>
                                        {{ __('jamiat.save_continue') }}
                                    </button>
                                    <button class="btn btn-primary" type="submit" name="action" value='save_exit'>
                                        <i class="fa-solid fa-save"></i>
                                        {{ __('jamiat.save_exit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="{{ asset('admin/select2/js/select2.full.js') }}"></script>
        <script type="text/javascript">
            $(".select2").select2({
                placeholder: "{{ __('lang.select_option') }}",
                theme: "bootstrap-5"
            });

            $("#school_country_id").change(function() {
                $.ajax({
                    url: "{{ route('load-provinces') }}",
                    method: 'GET',
                    data: {
                        'country_id': $("#school_country_id").val(),
                    },
                    success: function(response) {
                        $("#school_province_id").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $("#school_province_id").change(function() {
                $.ajax({
                    url: "{{ route('load-schools-districts') }}",
                    method: 'GET',
                    data: {
                        'province_id': $("#school_province_id").val(),
                    },
                    success: function(response) {
                        $("#school_district_id").html(response.districts);
                        $("#school_id").html(response.schools);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $("#school_district_id").change(function() {
                // $("#school_id").html('');
                $.ajax({
                    url: "{{ route('load-schools') }}",
                    method: 'GET',
                    data: {
                        'district_id': $("#school_district_id").val(),
                    },
                    success: function(response) {
                        console.log(response)
                        // $("#school_id").append(response.schools);
                        $("#school_id").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });





            $("#current_country_id").change(function() {
                $.ajax({
                    url: "{{ route('load-provinces') }}",
                    method: 'GET',
                    data: {
                        'country_id': $("#current_country_id").val(),
                    },
                    success: function(response) {
                        $("#current_province_id").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            $("#current_province_id").change(function() {
                $.ajax({
                    url: "{{ route('load-districts') }}",
                    method: 'GET',
                    data: {
                        'province_id': $("#current_province_id").val(),
                    },
                    success: function(response) {
                        $("#current_district_id").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            $("#permanent_country_id").change(function() {
                $.ajax({
                    url: "{{ route('load-provinces') }}",
                    method: 'GET',
                    data: {
                        'country_id': $("#permanent_country_id").val(),
                    },
                    success: function(response) {
                        $("#permanent_province_id").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            $("#permanent_province_id").change(function() {
                $.ajax({
                    url: "{{ route('load-districts') }}",
                    method: 'GET',
                    data: {
                        'province_id': $("#permanent_province_id").val(),
                    },
                    success: function(response) {
                        $("#permanent_district_id").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            $("#category_id").change(function() {
                $.ajax({
                    url: "{{ route('load-sub-categories') }}",
                    method: 'GET',
                    data: {
                        'category_id': $("#category_id").val(),
                    },
                    success: function(response) {
                        $("#sub_category_id").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });



            function intializeSchoolSelect(enableTag) {
                $('#school_id').select2({
                    placeholder: "{{ __('lang.select_option') }}",
                    tags: enableTag,
                    theme: "bootstrap-5",
                    createTag: function(params) {
                        var term = $.trim(params.term);

                        if (term === '') {
                            return null;
                        }

                        // Return the new tag as an option
                        return {
                            id: term, // Use the search term as the ID for new entries
                            text: term,
                            newTag: true // Mark it as a new tag
                        };
                    }
                });
            }

            $(document).ready(function() {
                // Initialize Select2 without tagging
                intializeSchoolSelect(false);

                // Event listener for checkbox change
                $('#new_school').change(function() {
                    if ($(this).is(':checked')) {
                        // Reinitialize Select2 with tags: true
                        intializeSchoolSelect(true);
                    } else {
                        // Reinitialize Select2 with tags: false
                        intializeSchoolSelect(false);
                    }
                });
            });



            $("#school_id").on('select2:select', function(e) {
                var selected = e.params.data;

                // Check if the selected option is a new tag (not an existing record)
                if (selected.newTag) {
                    // Make an AJAX call to store the new record
                    $.ajax({
                        url: "{{ route('school.storeFromSelect') }}", // Route to store new records
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name: selected.text,
                            country_id: $("#school_country_id").val(),
                            province_id: $("#school_province_id").val(),
                            district_id: $("#school_district_id").val(),
                        },
                        success: function(response) {
                            console.log(response)
                            var newOption = new Option(response.name, response.id, true, true);
                            $("#school_id").append(newOption).trigger('change');
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                $.each(errors, function(key, value) {
                                    $('#school_' + key).addClass('is-invalid');
                                    $('#school_' + key + '-error').removeClass('d-none').text(
                                        value[0]);
                                });
                            } else if (xhr.status === 401) {
                                console.error('Unauthorized:', xhr);
                            } else {
                                console.error('XHR Error:', xhr);
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app>
