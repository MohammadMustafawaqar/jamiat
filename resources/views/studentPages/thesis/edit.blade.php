@extends('studentPages.layouts.app')
@section('title','Edit thesis')
@section('content')
<div class="row">

    <div class="col-md-6 col-lg-7">
        <div class="card  animate__animated animate__bounceInRight">
            <div class="card-header">
                <h3> {{__('lang.edit_thesis')}}</h3>
            </div>
            <div class="card-body">
                <form action="{{route('thesis.update',$thesis->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <x-input type="textarea" name="details" label="{{__('lang.remarks')}}" :value="$thesis->details"/>
                    <x-input type="file" name="file_path" label="{{__('lang.file')}}" required="1"
                        accept=".doc,.docx,.pdf" />
                    <x-buttons.update />
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

</script>
