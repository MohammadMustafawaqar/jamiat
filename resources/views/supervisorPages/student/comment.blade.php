@extends('layouts.app')
@section('title','Thesis comments')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="bi bi-people"></i> {{__('lang.thesis_discussion')}}</h1>
        {{-- <p>Start a beautiful journey here</p> --}}
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('lang.dashboard')}}</a></li>
        <li class="breadcrumb-item"><a href="{{route('all-students')}}">{{__('lang.students')}}</a></li>
        <li class="breadcrumb-item"><a href="{{route('supervisor.student.show', $thesis->topic->user->student->id)}}">{{__('lang.theses')}}</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-8 col-lg-6">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.thesis_discussion')}}</h3>
            <div class="messanger" dir="ltr">
                <div id="messages" class="messages" style="max-height: 60vh !important;">
                    @foreach ($thesis->comments as $comment)
                    @if ($comment->user->user_type == 'Supervisor')
                    <div class="message me">
                        <img
                            src="{{ asset('logo.png') }}"
                            alt="{{$comment->user->name}}" />
                        <p class="info">
                            {{ $comment->comment }} <br>
                            <small class="text-light">
                                {{ $comment->created_at->diffForHumans() }}
                            </small>
                        </p>
                    </div>
                    @else
                    <div class="message"><img src="{{ $comment->user->student->image_path }}"
                            alt="{{$comment->user->name}}" />
                        <p class="info">
                            {{ $comment->comment }}<br>
                            <small class="text-muted">
                                {{ $comment->created_at->diffForHumans() }}
                            </small>
                        </p>
                    </div>
                    @endif
                    @endforeach

                </div>
                <form method="post" action="{{ route('comment.store') }}">
                    @csrf
                    <input type="hidden" name="thesis_id" value="{{ $thesis->id }}">
                    <div class="sender">
                        <input type="text" name="comment" placeholder="{{__('lang.comment')}}">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-send fs-5"></i></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.onload = function() {
        var scrollableDiv = document.getElementById("messages");
        scrollableDiv.scrollTop = scrollableDiv.scrollHeight;
    };
</script>
