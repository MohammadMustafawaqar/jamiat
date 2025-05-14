@extends('layouts.app')
@section('title','Students')

@push('styles')
<link rel="stylesheet" href="{{asset('admin/css/datatable.css')}}">
@endpush
@section('content')
<div class="app-title">
    <div>
        <h1><i class="bi bi-people"></i> {{__('lang.students')}}</h1>
        {{-- <p>Start a beautiful journey here</p> --}}
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('lang.dashboard')}}</a></li>
        <li class="breadcrumb-item"><a href="#">{{__('lang.students')}}</a></li>
    </ul>
</div>
<div class="row">

    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title"><i class="bi bi-list-ul"></i> {{__('lang.students')}}</h3>
            </div>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-striped data-table">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>{{__('lang.image')}}</th>
                                <th>{{__('lang.name')}}</th>
                                <th>{{__('lang.last_name')}}</th>
                                <th>{{__('lang.father_name')}}</th>
                                <th>{{__('lang.grand_father_name')}}</th>
                                <th>{{__('lang.dob')}}</th>
                                <th>{{__('lang.dob_qamari')}}</th>
                                <th>{{__('lang.current_address')}}</th>
                                <th>{{__('lang.permanent_address')}}</th>
                                <th>{{__('lang.phone')}}</th>
                                <th>{{__('lang.whatsapp')}}</th>
                                <th>{{__('lang.graduation_year')}}</th>
                                <th>{{__('lang.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <img src="{{$student->image_path}}" alt="Student image" height="70">
                                </td>
                                <td>{{$student->name}}</td>
                                <td>{{$student->last_name}}</td>
                                <td>{{$student->father_name}}</td>
                                <td>{{$student->grand_father_name}}</td>
                                <td>{{$student->dob}}</td>
                                <td>{{$student->dob_qamari}}</td>
                                <td>{{$student->currentDistrict->name}}</td>
                                <td>{{$student->permanentDistrict->name}}</td>
                                <td>{{$student->phone}}</td>
                                <td>{{$student->whatsapp}}</td>
                                <td>{{$student->graduation_year}}</td>
                                <td>
                                    <x-buttons.show :route="route('supervisor.student.show', $student->id)" />
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
<script type="text/javascript" src="{{asset('admin/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
    $('.data-table').DataTable();
</script>
