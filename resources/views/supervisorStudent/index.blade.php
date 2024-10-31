@extends('layouts.app')
@section('title','Supervisor\'s students')
@push('styles')
<link rel="stylesheet" href="{{asset('admin/css/datatable.css')}}">
<link rel="stylesheet" href="{{asset('admin/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/select2/css/select2-bootstrap-5-theme.min.css')}}">
@endpush
@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title"><i class="bi bi-list-ul"></i> {{__('lang.supervisor_student')}}</h3>
                {{--
                <x-buttons.modal modal="myModal" text="<i class='bi bi-plus'></i>" /> --}}
            </div>
            <div class="tile-body">
                <form action="{{route('supervisor-student.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <x-select col="col-sm-5 col-md-4" class="select2" :options="$supervisors" name="supervisor_id"
                            :label="__('lang.supervisor')" :required="1" />
                        <x-select col="col-sm-5 col-md-6" multiple class="select2" :options="$students"
                            name="student_id[]" id="student_id" :label="__('lang.student')" :required="1" />
                        <div class="col-sm-2 align-self-end mb-3 ">
                            <x-buttons.save />
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped data-table">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>{{__('lang.supervisor')}}</th>
                                <th>{{__('lang.student')}}</th>
                                <th>{{__('lang.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supervisorStudents as $supervisorStudent)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$supervisorStudent->supervisor->name}}</td>
                                <td>{{$supervisorStudent->student->name}}</td>
                                <td>
                                    <div class="btn-group" dir="ltr">
                                        <x-buttons.edit :route="route('supervisor-student.edit',$supervisorStudent)" />
                                        <x-buttons.delete
                                            :route="route('supervisor-student.destroy',$supervisorStudent)" />
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
<script src="{{asset('admin/select2/js/select2.full.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
    $('.data-table').DataTable();
    $(".select2").select2({
        placeholder: "{{__('lang.select_option')}}",
        theme: "bootstrap-5"
    });
</script>
@endpush