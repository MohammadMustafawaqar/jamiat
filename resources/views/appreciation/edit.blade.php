@extends('layouts.app')
@section('title','Edit appreciation')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.edit_appreciation')}}</h3>
            <div class="tile-body">
                <form action="{{route('appreciation.update',$appreciation)}}" method="post">
                    @csrf
                    @method('put')
                    <x-input name="name" :label="__('lang.name')" :value="$appreciation->name" :required="1" autofocus/>
                    <x-buttons.update/>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
