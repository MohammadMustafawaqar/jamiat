@extends('layouts.app')
@section('title','Schools')
@push('styles')
<link rel="stylesheet" href="{{asset('admin/css/datatable.css')}}">
<link rel="stylesheet" href="{{asset('admin/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/select2/css/select2-bootstrap-5-theme.min.css')}}">
@endpush

@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title"><i class="bi bi-list-ul"></i> {{__('lang.schools')}}</h3>
                @can('schools.create')
                <x-buttons.modal modal="myModal" text="<i class='bi bi-plus'></i>" />
                @endcan
            </div>
            <div class="tile-body">
                @can('schools.read')
                <div class="table-responsive">
                    <table class="table table-striped data-table">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>{{__('lang.name')}}</th>
                                <th>{{__('lang.address_type')}}</th>
                                <th>{{__('lang.country')}}</th>
                                <th>{{__('lang.province')}}</th>
                                <th>{{__('lang.district')}}</th>
                                <th>{{__('lang.details')}}</th>
                                <th>{{__('lang.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schools as $school)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$school->name}}</td>
                                <td>{{$school->addressType->name}}</td>
                                <td>{{$school->district->province->country->name}}</td>
                                <td>{{$school->district->province->name}}</td>
                                <td>{{$school->district->name}}</td>
                                <td>{{$school->details}}</td>
                                <td>
                                    <div class="btn-group" dir="ltr">
                                        @can('schools.edit')
                                        <x-buttons.edit :route="route('schools.edit',$school)" />
                                        @endcan
                                        @can('schools.delete')
                                        <x-buttons.delete :route="route('schools.destroy',$school)" />
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endcan
            </div>
        </div>
    </div>

    @can('schools.create')
    <!-- New Modal -->
    <x-modal id="myModal" title="<i class='bi bi-plus'></i>{{__('lang.school')}}">
        <form action="{{route('schools.store')}}" method="post">
            @csrf
            <x-input name="name" :label="__('lang.name')" :required="1" />
            <div class="row">
                <x-select col="col-6" :options="App\Models\AddressType::get()" name="address_type_id"
                    :label="__('lang.address_type')" :required="1" />
                <x-select col="col-6" class="select2" :options="App\Models\Country::get()" name="country_id"
                    :label="__('lang.country')" :required="1" />
                <x-select
                    :options="old('country_id') ? App\Models\Country::find(old('country_id'))->provinces : collect()"
                    col="col-6" name="province_id" :label="__('lang.province')" :required="1" />

                <x-select
                    :options="old('province_id') ? App\Models\Province::find(old('province_id'))->districts : collect()"
                    col="col-6" name="district_id" :label="__('lang.district')" :required="1" />
            </div>
            <x-input type="textarea" name="details" :label="__('lang.details')" />
            <x-buttons.save />
        </form>
    </x-modal>
    @endcan
</div>
@endsection

@push('scripts')
<script src="{{asset('admin/select2/js/select2.full.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
    $('.data-table').DataTable();
    $("th").addClass('text-end');
    $("#myModal").on("shown.bs.modal",function(){
        $("#name").focus();
    });
    @if($errors->any())
    const myModal=new bootstrap.Modal("#myModal",{
        keyboard:false
    });
    myModal.show();
    @endif
    $(".select2").select2({
        placeholder: "{{__('lang.select_option')}}",
        theme: "bootstrap-5",
        dropdownParent:$("#myModal")
    });
    $("#country_id").change(function(){
        $.ajax({
            url: "{{route('load-provinces')}}",
            method: 'GET',
            data: {
                'country_id': $("#country_id").val(),
            },
            success: function(response) {
                $("#province_id").html(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
    $("#province_id").change(function(){
        $.ajax({
            url: "{{route('load-districts')}}",
            method: 'GET',
            data: {
                'province_id': $("#province_id").val(),
            },
            success: function(response) {
                $("#district_id").html(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
</script>
@endpush