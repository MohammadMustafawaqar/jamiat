@extends('studentPages.layouts.app')
@section('title','Home')
@section('content')
<div class="row">
    <div class="col-md-6 col-lg-5">
        <div class="card mb-3 animate__animated animate__bounceInLeft">
            <div class="card-header">
                <h3>{{__('lang.new_topic_search_select')}}</h3>
            </div>
            <div class="card-body">
                <p class="card-text">{{__('messages.new_topic_message')}}</p>
                @error('title')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror
                <form action="{{route('topic.store')}}" method="POST">
                    @csrf
                    <div class="input-group">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="search" id="search" name="title" class="form-control" required
                                @if($topic)@if($topic->status->value!=2) disabled @endif @endif/>
                            <label class="form-label" for="search">{{__('lang.search')}}</label>
                        </div>
                        <button type="submit" class="btn btn-primary" data-mdb-ripple-init
                            @if($topic)@if($topic->status->value!=2) disabled @endif @endif>
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </form>
                <div class="spinner-border text-primary my-1" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <ul class="list-group list-group-light list-group-small mt-1  bg-secondary" id="searchResult">

                </ul>

                <h3>{{__('lang.my_topics')}}</h3>
                <table class="table table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>{{__('lang.title')}}</th>
                            <th>{{__('lang.status')}}</th>
                            <th>{{__('lang.fee')}}</th>
                            <th>{{__('lang.remarks')}}</th>
                            {{-- <th>{{__('lang.action')}}</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topics as $topic)
                        <tr>
                            <td>{{$topic->title}}</td>
                            <td>
                                {!! $topic->status->label() !!}
                            </td>
                            <td>
                                @if ($topic->fee)
                                <span class="me-1 badge bg-success">{{__('lang.paid')}}</span>
                                @else
                                <span class="me-1 badge bg-secondary">{{__('lang.waiting')}}</span>
                                @endif
                            </td>
                            <td>{{$topic->remarks}}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-7">
        <div class="card  animate__animated animate__bounceInRight">
            <div class="card-header">
                <h3> {{__('lang.thesis')}}</h3>
            </div>
            <div class="card-body">
                <p class="card-text">{{__('messages.upload_thesis_file')}}</p>
                @if($topic)
                @if($topic->status->value==1)
                <form action="{{route('thesis.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <x-input type="textarea" name="details" label="{{__('lang.remarks')}}" />
                    <x-input type="file" name="file_path" label="{{__('lang.file')}}" required="1"
                        accept=".doc,.docx,.pdf" />
                    <x-buttons.save />
                </form>
                @endif
                @endif
                <div class="table-responsive mt-2">
                    <table class="table table-sm table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>{{__('lang.details')}}</th>
                                <th>{{__('lang.file')}}</th>
                                <th>{{__('lang.status')}}</th>
                                <th>{{__('lang.marks')}}</th>
                                <th>{{__('lang.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($theses as $thesis)
                            <tr>
                                <td>{{$thesis->details}}</td>
                                <td>
                                    <a href="{{$thesis->file_path}}" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                </td>
                                <td>
                                    {!! $thesis->status->label() !!}
                                </td>
                                <td>{{$thesis->marks}}</td>
                                <td>
                                    <div class="btn-group">
                                        <x-buttons.edit :route="route('thesis.edit',$thesis)" />
                                        <x-buttons.delete :route="route('thesis.destroy',$thesis)" />
                                        <a href="{{ route('thesis.show',$thesis) }}" title="View"
                                            class="btn btn-sm btn-info position-relative">
                                            <i class="fa fa-eye"></i>
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                {{App\Models\Comment::where('thesis_id',$thesis->id)->where('user_id','!=',Auth::id())->count()}}
                                            </span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#search").keyup(function(){
        $.ajax({
            url: "{{route('topic.search')}}",
            method: 'GET',
            data: {
                'title': $("#search").val(),
            },
            success: function(response) {
                $("#searchResult").html(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
</script>
@endpush