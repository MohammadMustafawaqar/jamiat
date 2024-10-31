@extends('layouts.app')
@section('title','Edit committee member')
@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.committee_member')}}</h3>
            <div class="tile-body">
                <form action="{{route('committee-member.update',$committeeMember)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <x-input name="name" :label="__('lang.name')" :value="$committeeMember->name" :required="1" />
                        <x-input name="last_name" :label="__('lang.last_name')" :value="$committeeMember->last_name" :required="1" />
                        <x-input name="father_name" :label="__('lang.father_name')" :value="$committeeMember->father_name" :required="1" />
                        <x-input name="job" :label="__('lang.job')" :value="$committeeMember->job" :required="1" />
                        <x-input name="phone" :label="__('lang.phone')" :value="$committeeMember->phone" :required="1" />
                    </div>
                    <x-buttons.update />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
