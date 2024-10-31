@extends('layouts.app')
@section('title','Edit country')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.edit_country')}}</h3>
            <div class="tile-body">
                <form action="{{route('country.update',$country)}}" method="post">
                    @csrf
                    @method('put')
                    <x-input name="name" :label="__('lang.name')" :value="$country->name" :required="1" autofocus/>
                    <x-buttons.update/>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
