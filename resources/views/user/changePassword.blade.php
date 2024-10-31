@extends('layouts.app')
@section('title','Change password')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.change_password')}}</h3>
            <div class="tile-body">
                <form action="{{ route('user.change-password') }}" method="post">
                    @csrf
                    <div class="mb-3 has-danger">
                        <label class="form-form-label" for="current_password">{{__('lang.current_password')}}</label>
                        <input class="form-control @error('current_password') is-invalid @enderror"
                            name="current_password" id="current_password" type="password" autofocus>
                        @error('current_password')
                        <span class="form-control-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3 has-danger">
                        <label class="form-form-label" for="password">{{__('lang.new_password')}}</label>
                        <input class="form-control @error('password') is-invalid @enderror" name="password"
                            id="password" type="password">
                        @error('password')
                        <span class="form-control-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3 has-danger">
                        <label class="form-form-label" for="password_confirmation">{{__('lang.password_confirmation')}}</label>
                        <input class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" id="password_confirmation" type="password">
                        @error('password_confirmation')
                        <span class="form-control-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <x-buttons.update/>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection