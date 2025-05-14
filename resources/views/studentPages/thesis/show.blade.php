@extends('studentPages.layouts.app')
@section('title','Thesis information')
@section('content')
<div class="row">

    <div class="col-md-6 col-lg-7">
        <div class="card">
            <div class="card-header">
                <h3> {{__('lang.thesis_discussion')}}</h3>
                <p class="card-text"> <a href="{{$thesis->file_path}}" target="_blank">
                        <i class="fa fa-file"></i>
                    </a> {{$thesis->details}}</p>
            </div>
            <div class="card-body" id="messages" data-mdb-perfect-scrollbar="true"
                style="position: relative; height: 50vh;overflow: auto;background-color: #eee;">
                @foreach ($thesis->comments as $comment)
                @if ($comment->user->user_type == 'Student')
                <div class="d-flex flex-row justify-content-start  animate__animated animate__bounceInUp">
                    <img src="{{ $comment->user->student->image_path }}" alt="Admin"
                        style="width: 45px; height: 100%; border-radius: 50%;">
                    <div>
                        <p class="small p-2 ms-3 rounded-3 bg-info text-white">
                            {{ $comment->user->name }}<br>
                            {{ $comment->comment }}<br>
                            <small class="text-muted">
                                {{ $comment->created_at->diffForHumans() }}
                            </small>
                        </p>
                    </div>
                </div>
                @else
                <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                    <div>
                        <p class="small p-2 me-3 rounded-3 bg-white">
                            {{ $comment->comment }} <br>
                            <small class="text-muted">
                                {{ $comment->created_at->diffForHumans() }}
                            </small>
                        </p>

                    </div>
                    <img src="{{ asset('logo.png') }}"
                        alt="Author" style="width: 45px; height: 100%; border-radius: 50%;">
                </div>
                @endif
                @endforeach
            </div>
            <div class="card-footer">
                <form method="post" action="{{ route('comment.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="thesis_id" value="{{ $thesis->id }}">
                    <!-- Message input -->
                    <x-input type="textarea" name="comment" label="{{__('lang.comment')}}" />
                    <x-buttons.save />
                </form>
                <div id="error-messages"></div>
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
