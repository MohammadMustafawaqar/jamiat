@extends('layouts.app')
@section('title','Edit sub category')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.edit_sub_category')}}</h3>
            <div class="tile-body">
                <form action="{{route('sub-category.update',$subCategory)}}" method="post">
                    @csrf
                    @method('put')
                    <x-input name="name" :label="__('lang.name')" :value="$subCategory->name" :required="1" autofocus/>
                    <x-buttons.update/>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
