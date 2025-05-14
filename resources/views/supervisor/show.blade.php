@extends('layouts.app')
@section('title','Supervisor')
@push('styles')
<link rel="stylesheet" href="{{asset('admin/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/select2/css/select2-bootstrap-5-theme.min.css')}}">
@endpush
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="tile">
            <h3 class="tile-title">{{__('lang.supervisor')}}</h3>
            <div class="tile-body text-center">
                <table class="table table-bordered mt-2">
                    <tr>
                        <th>{{__('lang.name')}}</th>
                        <th>{{$supervisor->name}}</th>
                    </tr>
                    <tr>
                        <th>{{__('lang.father_name')}}</th>
                        <th>{{$supervisor->father_name}}</th>
                    </tr>
                    <tr>
                        <th>{{__('lang.phone')}}</th>
                        <th>{{$supervisor->phone}}</th>
                    </tr>
                    <tr>
                        <th>{{__('lang.whatsapp')}}</th>
                        <th>{{$supervisor->whatsapp}}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title"><i class="bi bi-list-ul"></i> {{__('lang.students')}}</h3>
            </div>
            <div class="tile-body">
                <form action="{{route('supervisor-student.store')}}" method="post">
                    @csrf
                    <input type="hidden" name="supervisor_id" value="{{$supervisor->id}}">
                    <x-select col="col-lg-8" class="select2" :options="App\Models\Student::get()"
                        id="student_id" name="student_id" :label="__('lang.student')" :required="1" />
                    <div class="col-sm-2 align-self-end mb-3 ">
                        <x-buttons.save />
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped data-table">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>{{__('lang.image')}}</th>
                                <th>{{__('lang.name')}}</th>
                                <th>{{__('lang.last_name')}}</th>
                                <th>{{__('lang.father_name')}}</th>
                                <th>{{__('lang.dob')}}</th>
                                <th>{{__('lang.current_address')}}</th>
                                <th>{{__('lang.phone')}}</th>
                                <th>{{__('lang.whatsapp')}}</th>
                                <th>{{__('lang.graduation_year')}}</th>
                                <th>{{__('lang.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supervisor->students as $student)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <img src="{{$student->image_path}}" alt="Student image" height="70">
                                </td>
                                <td>{{$student->name}}</td>
                                <td>{{$student->last_name}}</td>
                                <td>{{$student->father_name}}</td>
                                <td>{{$student->dob}}</td>
                                <td>{{$student->currentDistrict->name}}</td>
                                <td>{{$student->phone}}</td>
                                <td>{{$student->whatsapp}}</td>
                                <td>{{$student->graduation_year}}</td>
                                <td>
                                    <x-buttons.delete :route="route('supervisor-student.destroy',$student->pivot->id)" />
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
<script type="text/javascript">
    $(".select2").select2({
        placeholder: "{{__('lang.select_option')}}",
        theme: "bootstrap-5"
    });
</script>
