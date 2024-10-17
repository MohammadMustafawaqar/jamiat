@extends('layouts.app')
@section('title','Edit district')
@section('content')

<div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.edit_district')}}</h3>
            <div class="tile-body">
                <form action="{{route('district.update',$district)}}" method="post">
                    @csrf
                    @method('put')
                    <x-input name="name" :label="__('lang.name')" :required="1" :value="$district->name" autofocus/>
                    <x-buttons.update />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
