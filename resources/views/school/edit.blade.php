@extends('layouts.app')
@section('title','Edit school')
@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.edit_school')}}</h3>
            <div class="tile-body">
                <form action="{{route('schools.update',$school)}}" method="post">
                    @csrf
                    @method('put')
                    <x-input name="name" :label="__('lang.name')" :value="$school->name" :required="1" autofocus />
                    <div class="row">
                        <x-select col="col-6" :options="App\Models\AddressType::get()" name="address_type_id"
                            :label="__('lang.address_type')" :required="1" />
                        <x-select col="col-6" :options="$countries" name="country_id" :label="__('lang.country')"
                            :required="1" />
                        <x-select col="col-6" :options="$provinces" name="province_id" :label="__('lang.province')"
                            :required="1" />
                        <x-select col="col-6" :options="$districts" name="district_id" :label="__('lang.district')"
                            :required="1" />
                    </div>
                    <x-input type="textarea" name="details" :label="__('lang.details')" />
                    <x-buttons.update />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $("#address_type_id").val("{{$school->address_type_id}}");
    $("#country_id").val("{{$school->district->province->country_id}}");
    $("#province_id").val("{{$school->district->province_id}}");
    $("#district_id").val("{{$school->district_id}}");
</script>
