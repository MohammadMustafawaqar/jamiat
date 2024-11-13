@extends('layouts.app')
@section('title', 'Edit student')
@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/select2/css/select2-bootstrap-5-theme.min.css') }}">
@endpush
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="bi bi-people"></i> {{ __('lang.students') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('lang.edit_student') }}</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h3 class="title"><i class="bi bi-plus"></i> {{ __('lang.edit_student') }}</h3>
                    <a class="btn btn-primary" href="{{ route('students.index') }}"><i class='bi bi-list-ul'></i></a>
                </div>
                <div class="tile-body">
                    <form action="{{ route('students.update', $student) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="form_id" :label="__('lang.form_id')"
                                :required="1" value="{{ $student->form_id }}" autofocus />
                            <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="name" :label="__('lang.name')"
                                :required="1" value="{{ $student->name }}" />
                            {{-- <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="name_en" :label="__('lang.name_en')"
                            :required="1"  value="{{$student->name_en}}"/> --}}
                            <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="last_name" :label="__('lang.last_name')"
                                :required="1" value="{{ $student->last_name }}" />
                            {{-- <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="last_name_en"
                            :label="__('lang.last_name_en')" :required="1"  value="{{$student->last_name_en}}"/> --}}
                            <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="father_name" :label="__('lang.father_name')"
                                :required="1" value="{{ $student->father_name }}" />
                            {{-- <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="father_name_en"
                            :label="__('lang.father_name_en')" :required="1"  value="{{$student->father_name_en}}"/> --}}
                            <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="grand_father_name" :label="__('lang.grand_father_name')"
                                :required="1" value="{{ $student->grand_father_name }}" />
                            {{-- <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="grand_father_name_en"
                            :label="__('lang.grand_father_name_en')" :required="1"  value="{{$student->grand_father_name_en}}"/> --}}
                            <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" display="name_ps" :options="$genders"
                                name="gender_id" :label="__('lang.gender')" :required="1" :selected="$student->gender_id" />
                            {{-- <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="dob" :label="__('lang.dob')"
                                :required="1" value="{{ $student->dob }}" /> --}}
                            <x-qamari-input name='dob_qamari' id='dob_qamari' :label="__('lang.dob_qamari')" format="yyyy/mm/dd"
                                col='col-6 col-md-4 col-lg-3 col-xl-2' :required="1" :value="$student->dob_qamari" />

                            <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="phone" :label="__('lang.phone')"
                                :required="1" value="{{ $student->phone }}" />
                            <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="whatsapp" :label="__('lang.whatsapp')"
                                :required="1" value="{{ $student->whatsapp }}" />
                            <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="graduation_year" :label="__('lang.graduation_year')"
                                :required="1" value="{{ $student->graduation_year }}" />
                            {{-- <x-input type="file" col="col-6 col-md-4 col-lg-3 col-xl-2" name="image_path"
                                :label="__('lang.image')" :required="1" /> --}}

                            <x-select2 col="col-6 col-md-4 col-lg-3 col-xl-2" :list="$nic_types" name="tazkira_type"
                                value='value' text='text' :label="__('jamiat.nic_type')" :selected_value="$student->tazkira->type" :required='1' />

                            <x-input type='text' name='tazkira_no' :label="__('jamiat.tazkira_no')"
                                col='col-6 col-md-4 col-lg-3 col-xl-2' :required='1'
                                value="{{ $student->tazkira->tazkira_no }}" />

                            <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" :options="JamiaHelper::educationLevels()" :display="Settings::trans('en_name', 'pa_name', 'da_name', 'ar_name')"
                                name="education_level_id" :label="__('jamiat.edu_level')" :required="1" class='select2'
                                :selected="$student->education_level_id"
                                />

                            <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" :options="JamiaHelper::Languages()" :display="Settings::trans('en_name', 'pa_name', 'da_name', 'ar_name')"
                                name="language_id" :label="__('jamiat.mother_tongue')" :required="1" class='select2'
                                :selected="$student->language_id"
                                />
                            {{-- 
                        <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="$schools"
                            name="school_id" :label="__('lang.school')" :required="1" :selected="$student->school_id" />
                      --}}
                            {{-- <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="$categories"
                            name="category_id" :label="__('lang.category')" :required="1"  :selected="$student->subCategory->category_id"/>
                        <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2"
                            :options="App\Models\Category::find($student->subCategory->category_id)->subCategories"
                            name="sub_category_id" :label="__('lang.sub_category')" :required="1"  :selected="$student->sub_category_id"/> --}}

                            <div class="col-12">
                                <hr />
                                <div class="row">
                                    <h4 class="col-4">{{ __('lang.school') }}</h4>
                                    <x-checkbox col='col-sm-2' name='new_school' id='new_school' :label="__('jamiat.new_school')"
                                        value='true' />
                                </div>
                            </div>

                            <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="$countries"
                                name="school_country_id" :label="__('lang.country')" :required="1" :selected="old('school_country_id', 1)" />
                            <!-- Ensure selected country -->

                            <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="App\Models\Province::get()"
                                name="school_province_id" :label="__('lang.province')" :required="1" :selected="$student?->school?->province?->country_id" />

                            <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="App\Models\District::all()"
                                id='school_district_id' name="school_district_id" :label="__('lang.district')" :required="1"
                                :selected="$student?->school?->district_id" />


                            <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" id="school_id" :options="App\Models\School::all()"
                                name="school_id" :label="__('lang.school')" :required="1" :selected="$student->school?->id" class="select2" />

                            <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" :options="$appreciations" name="appreciation_id"
                                :label="__('lang.appreciation')" :required="1" :selected="$student->appreciation_id" />

                            <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="graduation_year" :value="$student->graduation_year"
                                :label="__('lang.graduation_year')" :required="1" />



                            <div class="col-12">
                                <hr />
                                <h4>{{ __('lang.current_address') }}</h4>
                            </div>
                            <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="$countries"
                                name="current_country_id" :label="__('lang.country')" :required="1" :selected="$student->currentDistrict->province->country_id" />
                            <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="App\Models\Country::find($student->currentDistrict->province->country_id)
                                ->provinces"
                                name="current_province_id" :label="__('lang.province')" :required="1" :selected="$student->currentDistrict->province_id" />
                            <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="App\Models\Province::find($student->currentDistrict->province_id)->districts"
                                name="current_district_id" :label="__('lang.district')" :required="1" :selected="$student->current_district_id" />
                            <x-input col="col-6 col-md-4 col-lg-3" name="current_village" :label="__('lang.village')"
                                :required="1" value="{{ $student->current_village }}" />
                            <div class="col-12">
                                <hr />
                                <h4>{{ __('lang.permanent_address') }}</h4>
                            </div>
                            <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="$countries"
                                name="permanent_country_id" :label="__('lang.country')" :required="1" :selected="$student->permanentDistrict->province->country_id" />
                            <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="App\Models\Country::find($student->permanentDistrict->province->country_id)
                                ->provinces"
                                name="permanent_province_id" :label="__('lang.province')" :required="1" :selected="$student->permanentDistrict->province_id" />
                            <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="App\Models\Province::find($student->permanentDistrict->province_id)->districts"
                                name="permanent_district_id" :label="__('lang.district')" :required="1" :selected="$student->permanent_district_id" />
                            <x-input col="col-6 col-md-4 col-lg-3" name="permanent_village" :label="__('lang.village')"
                                :required="1" value="{{ $student->permanent_village }}" />
                        </div>

                        <div class="d-flex justify-content-between bg-light p-3">
                            <x-btn-back route="admin.student.form.evaluation" />

                            <x-buttons.save />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/select2/js/select2.full.js') }}"></script>
    <script type="text/javascript">
        $(".select2").select2({
            placeholder: "{{ __('lang.select_option') }}",
            theme: "bootstrap-5"
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
    </script>
@endpush
