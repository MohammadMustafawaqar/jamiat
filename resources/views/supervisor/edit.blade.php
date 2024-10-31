@extends('layouts.app')
@section('title','Edit supervisor')
@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.edit_supervisor')}}</h3>
            <div class="tile-body">
                <form action="{{route('supervisors.update',$supervisor)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <x-input name="name" :label="__('lang.name')" :value="$supervisor->name" :required="1" />
                        <x-input name="last_name" :label="__('lang.last_name')" :value="$supervisor->last_name" :required="1" />
                        <x-input name="father_name" :label="__('lang.father_name')" :value="$supervisor->father_name" :required="1" />
                        <x-input name="phone" :label="__('lang.phone')" :value="$supervisor->phone" :required="1" />
                        <x-input name="whatsapp" :label="__('lang.whatsapp')" :value="$supervisor->whatsapp" :required="1" />
                    </div>
                    <x-buttons.update />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
