@extends('layouts.app')
@section('title','Edit category')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.edit_category')}}</h3>
            <div class="tile-body">
                <form action="{{route('category.update',$category)}}" method="post">
                    @csrf
                    @method('put')
                    <x-input name="name" :label="__('lang.name')" :value="$category->name" :required="1" autofocus/>
                    <x-buttons.update/>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
