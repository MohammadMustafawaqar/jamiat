@extends('layouts.app')
@section('title','Edit studen to superviser')
@push('styles')
<link rel="stylesheet" href="{{asset('admin/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/select2/css/select2-bootstrap-5-theme.min.css')}}">
@endpush
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="tile">
            <h3 class="tile-title"><i class="bi bi-edit"></i></h3>
            <div class="tile-body">
                <form action="{{route('supervisor-student.update',$supervisorStudent)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <x-select col="col-sm-5 col-md-4" class="select2" :selected="$supervisorStudent->supervisor_id" :options="$supervisors" name="supervisor_id"
                            :label="__('lang.supervisor')" :required="1" />
                        <x-select col="col-sm-5 col-md-6" class="select2"  :selected="$supervisorStudent->student_id" :options="$students" name="student_id"
                            :label="__('lang.student')" :required="1" />
                        <div class="col-sm-2 align-self-end mb-3 ">
                            <x-buttons.update />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{asset('admin/select2/js/select2.full.js')}}"></script>
<script type="text/javascript">
    $(".select2").select2({
        placeholder: "{{__('lang.select_option')}}",
        theme: "bootstrap-5"
    });
</script>
@endpush