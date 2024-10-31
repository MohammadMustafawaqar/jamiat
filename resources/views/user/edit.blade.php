@extends('layouts.app')
@section('title','Edit user')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title">Edit user</h3>
                <a class="btn btn-primary icon-btn" href="{{route('user.index')}}"><i
                        class="bi bi-list-check me-2"></i></a>
            </div>
            <div class="tile-body">
                <form method="POST" action="{{ route('user.update',$user) }}">
                    @csrf
                    @method('put')
                    <x-input :value="$user->name" name="name" :label="__('lang.name')" :required="1" />
                    <x-input :value="$user->email" type="email" name="email" :label="__('lang.email')" :required="1" />
                    <x-input type="password" name="password" :label="__('lang.password')" :required="1" />
                    <x-input type="password" name="password_confirmation" :label="__('lang.password_confirmation')" :required="1" />
                    <x-buttons.update />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
