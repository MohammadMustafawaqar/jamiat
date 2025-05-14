@extends('studentPages.layouts.app')
@section('title','Profile')
@push('styles')
<link rel="stylesheet" href="{{asset('admin/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/select2/css/select2-bootstrap-5-theme.min.css')}}">
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card  animate__animated animate__bounceInLeft">
            <div class="card-header">
                <h3>{{__('lang.edit_profile')}}</h3>
            </div>
            <div class="card-body">
                @php
                $student=App\Models\Student::where('user_id',Auth::id())->first();
                @endphp
                 @if ($errors->any())
                 <div class="alert alert-danger">
                     <ul>
                         @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                 </div>
                 @endif
                <form action="{{route('students.profile.update',$student->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="name" :label="__('lang.name')"
                            :required="1" value="{{$student->name}}" autofocus/>
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="name_en" :label="__('lang.name_en')"
                            :required="1" value="{{$student->name_en}}" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="last_name" :label="__('lang.last_name')"
                            :required="1" value="{{$student->last_name}}" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="last_name_en"
                            :label="__('lang.last_name_en')" :required="1" value="{{$student->last_name_en}}" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="father_name"
                            :label="__('lang.father_name')" :required="1" value="{{$student->father_name}}" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="father_name_en"
                            :label="__('lang.father_name_en')" :required="1" value="{{$student->father_name_en}}" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="grand_father_name"
                            :label="__('lang.grand_father_name')" :required="1"
                            value="{{$student->grand_father_name}}" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="grand_father_name_en"
                            :label="__('lang.grand_father_name_en')" :required="1"
                            value="{{$student->grand_father_name_en}}" />
                        <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" display="name_ps" :options="App\Models\Gender::get()"
                            name="gender_id" :label="__('lang.gender')" :required="1" :selected="$student->gender_id" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="dob" :label="__('lang.dob')" :required="1"
                            value="{{$student->dob}}" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="dob_qamari" :label="__('lang.dob_qamari')"
                            :required="1" value="{{$student->dob_qamari}}" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="phone" :label="__('lang.phone')"
                            :required="1" value="{{$student->phone}}" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="whatsapp" :label="__('lang.whatsapp')"
                            :required="1" value="{{$student->whatsapp}}" />
                        <x-input col="col-6 col-md-4 col-lg-3 col-xl-2" name="graduation_year"
                            :label="__('lang.graduation_year')" :required="1" value="{{$student->graduation_year}}" />
                        <x-input type="file" col="col-6 col-md-4 col-lg-3 col-xl-2" name="image_path"
                            :label="__('lang.image')" :required="1" />

                        <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" :options="App\Models\Appreciation::get()"
                            name="appreciation_id" :label="__('lang.appreciation')" :required="1"
                            :selected="$student->appreciation_id" />
                        <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2" :options="App\Models\Category::get()"
                            name="category_id" :label="__('lang.category')" :required="1"
                            :selected="$student->subCategory->category_id" />
                        <x-select col="col-6 col-md-4 col-lg-3 col-xl-2" class="select2"
                            :options="App\Models\Category::find($student->subCategory->category_id)->subCategories"
                            name="sub_category_id" :label="__('lang.sub_category')" :required="1"
                            :selected="$student->sub_category_id" />

                        <div class="col-12">
                            <hr />
                            <h4>{{__('lang.current_address')}}</h4>
                        </div>
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="App\Models\Country::get()"
                            name="current_country_id" :label="__('lang.country')" :required="1"
                            :selected="$student->currentDistrict->province->country_id" />
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2"
                            :options="App\Models\Country::find($student->currentDistrict->province->country_id)->provinces"
                            name="current_province_id" :label="__('lang.province')" :required="1"
                            :selected="$student->currentDistrict->province_id" />
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2"
                            :options="App\Models\Province::find($student->currentDistrict->province_id)->districts"
                            name="current_district_id" :label="__('lang.district')" :required="1"
                            :selected="$student->current_district_id" />
                        <x-input col="col-6 col-md-4 col-lg-3" name="current_village" :label="__('lang.village')"
                            :required="1" value="{{$student->current_village}}" />
                        <div class="col-12">
                            <hr />
                            <h4>{{__('lang.permanent_address')}}</h4>
                        </div>
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2" :options="App\Models\Country::get()"
                            name="permanent_country_id" :label="__('lang.country')" :required="1"
                            :selected="$student->permanentDistrict->province->country_id" />
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2"
                            :options="App\Models\Country::find($student->permanentDistrict->province->country_id)->provinces"
                            name="permanent_province_id" :label="__('lang.province')" :required="1"
                            :selected="$student->permanentDistrict->province_id" />
                        <x-select col="col-6 col-md-4 col-lg-3" class="select2"
                            :options="App\Models\Province::find($student->permanentDistrict->province_id)->districts"
                            name="permanent_district_id" :label="__('lang.district')" :required="1"
                            :selected="$student->permanent_district_id" />
                        <x-input col="col-6 col-md-4 col-lg-3" name="permanent_village" :label="__('lang.village')"
                            :required="1" value="{{$student->permanent_village}}" />
                    </div>
                    <x-buttons.update />
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
