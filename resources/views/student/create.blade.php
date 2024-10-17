@extends('layouts.app')
@section('title','Create student')
@push('styles')
<link rel="stylesheet" href="{{asset('admin/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/select2/css/select2-bootstrap-5-theme.min.css')}}">
@endpush
@section('content')
<div class="app-title">
    <div>
        <h1><i class="bi bi-people"></i> {{__('lang.students')}}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        <li class="breadcrumb-item"><a href="#">{{__('lang.new_student')}}</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title"><i class="bi bi-plus"></i> {{__('lang.new_student')}}</h3>
                <a class="btn btn-primary" href="{{route('students.index')}}"><i class='bi bi-list-ul'></i></a>
            </div>
            <div class="tile-body">
                {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif --}}
                <form action="{{route('students.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="form_id" :label="__('lang.form_id')"
                            :required="1" autofocus />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="name" :label="__('lang.name')"
                            :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="name_en" :label="__('lang.name_en')"
                            :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="last_name" :label="__('lang.last_name')"
                            :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="last_name_en"
                            :label="__('lang.last_name_en')" :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="father_name"
                            :label="__('lang.father_name')" :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="father_name_en"
                            :label="__('lang.father_name_en')" :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="grand_father_name"
                            :label="__('lang.grand_father_name')" :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="grand_father_name_en"
                            :label="__('lang.grand_father_name_en')" :required="1" />
                        <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" display="name_ps" :options="$genders"
                            name="gender_id" :label="__('lang.gender')" :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="dob" :label="__('lang.dob')"
                            :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="dob_qamari" :label="__('lang.dob_qamari')"
                            :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="phone" :label="__('lang.phone')"
                            :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="whatsapp" :label="__('lang.whatsapp')"
                            :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="graduation_year"
                            :label="__('lang.graduation_year')" :required="1" />
                        <x-input type="file" col="col-6 col-md-4 col-lg-3 col-xl-2" name="image_path"
                            :label="__('lang.image')" :required="1" />

                        <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="$schools"
                            name="school_id" :label="__('lang.school')" :required="1" />
                        <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" :options="$appreciations"
                            name="appreciation_id" :label="__('lang.appreciation')" :required="1" />
                        <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="$categories"
                            name="category_id" :label="__('lang.category')" :required="1" />
                        <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2"
                            :options="old('category_id') ? App\Models\Category::find(old('category_id'))->subCategories : collect()"
                            name="sub_category_id" :label="__('lang.sub_category')" :required="1" />

                        <div class="col-12">
                            <hr />
                            <h4>{{__('lang.current_address')}}</h4>
                        </div>
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="$countries"
                            name="current_country_id" :label="__('lang.country')" :required="1" />
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2"
                            :options="old('current_country_id') ? App\Models\Country::find(old('current_country_id'))->provinces : collect()"
                            name="current_province_id" :label="__('lang.province')" :required="1" />
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2"
                            :options="old('current_province_id') ? App\Models\Province::find(old('current_province_id'))->districts : collect()"
                            name="current_district_id" :label="__('lang.district')" :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3" name="current_village" :label="__('lang.village')"
                            :required="1" />
                        <div class="col-12">
                            <hr />
                            <h4>{{__('lang.permanent_address')}}</h4>
                        </div>
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="$countries"
                            name="permanent_country_id" :label="__('lang.country')" :required="1" />
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2"
                            :options="old('permanent_country_id') ? App\Models\Country::find(old('permanent_country_id'))->provinces : collect()"
                            name="permanent_province_id" :label="__('lang.province')" :required="1" />
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2"
                            :options="old('permanent_province_id') ? App\Models\Province::find(old('permanent_province_id'))->districts : collect()"
                            name="permanent_district_id" :label="__('lang.district')" :required="1" />
                        <x-input col="col-6 col-md-4 col-lg-3" name="permanent_village" :label="__('lang.village')"
                            :required="1" />
                    </div>
                    <x-buttons.save />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('admin/select2/js/select2.full.js')}}"></script>
<script type="text/javascript">
    $(".select2").select2({
        placeholder: "{{__('lang.select_option')}}",
        theme: "bootstrap-5"
    });
    $("#current_country_id").change(function(){
        $.ajax({
            url: "{{route('load-provinces')}}",
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
    $("#current_province_id").change(function(){
        $.ajax({
            url: "{{route('load-districts')}}",
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
    $("#permanent_country_id").change(function(){
        $.ajax({
            url: "{{route('load-provinces')}}",
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
    $("#permanent_province_id").change(function(){
        $.ajax({
            url: "{{route('load-districts')}}",
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
    $("#category_id").change(function(){
        $.ajax({
            url: "{{route('load-sub-categories')}}",
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
</script>
@endpush