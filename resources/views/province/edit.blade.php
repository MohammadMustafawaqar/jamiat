@extends('layouts.app')
@section('title','Edit province')
@section('content')

<div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.edit_province')}}</h3>
            <div class="tile-body">
                <form action="{{route('province.update',$province)}}" method="post">
                    @csrf
                    @method('put')
                    <x-input name="name" :label="__('lang.name')" :required="1" :value="$province->name" />
                    <x-buttons.update />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
