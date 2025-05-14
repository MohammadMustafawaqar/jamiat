@extends('layouts.app')
@section('title','Student file')

@push('styles')
<link rel="stylesheet" href="{{asset('admin/css/datatable.css')}}">
@endpush
@section('content')
<div class="app-title">
    <div>
        <h1><i class="bi bi-people"></i> د فاضل د رسالې معلومات </h1>
        {{-- <p>Start a beautiful journey here</p> --}}
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('lang.dashboard')}}</a></li>
        <li class="breadcrumb-item"><a href="{{route('all-students')}}">{{__('lang.students')}}</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="tile">
            <div class="tile-body text-center">
                <img src="{{$student->image_path}}" alt="IMG" class="rounded-circle"
                    style="max-height: 140px;border:4px solid lightblue;">
                <table class="table table-bordered mt-2">
                    <tr>
                        <th>{{__('lang.form_id')}}</th>
                        <th>{{$student->form_id}}</th>
                    </tr>
                    <tr>
                        <th>{{__('lang.name')}}</th>
                        <th>{{$student->full_name}}</th>
                    </tr>
                    <tr>
                        <th>{{__('lang.father_name')}}</th>
                        <th>{{$student->father_name}}</th>
                    </tr>
                    <tr>
                        <th>{{__('lang.grand_father_name')}}</th>
                        <th>{{$student->grand_father_name}}</th>
                    </tr>
                    <tr>
                        <th>{{__('lang.phone')}}</th>
                        <th>{{$student->phone}}</th>
                    </tr>
                    <tr>
                        <th>{{__('lang.whatsapp')}}</th>
                        <th>{{$student->whatsapp}}</th>
                    </tr>
                    <tr>
                        <th>{{__('lang.current_address')}}</th>
                        <th>{{$student->current_address}}</th>
                    </tr>
                    <tr>
                        <th>{{__('lang.permanent_address')}}</th>
                        <th>{{$student->current_address}}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title"><i class="bi bi-list-ul"></i> د فاضل د رسالې معلومات</h3>
            </div>
            <div class="tile-body">
                <div class="table-responsive mt-2">
                    <table class="table table-bordered">
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

                            @if($student->user->topic?->theses)
                            @foreach ($student->user->topic?->theses as $thesis)
                            <tr>
                                <td>{{$thesis->details}}</td>
                                <td>
                                    <a href="{{$thesis->file_path}}" target="_blank">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </a>
                                </td>
                                <td>
                                    {!! $thesis->status->label() !!}
                                </td>
                                <td>{{$thesis->marks}}</td>
                                <td>
                                    <x-buttons.modal class="btn-status"
                                        upadate-route="{{route('supervisor.thesis.update',$thesis->id)}}"
                                        current-status="{{$thesis->status}}" modal="myModal" text="تغیر حالت" />
                                    <a href="{{ route('supervisor.student.thesis.show',$thesis->id) }}" title="View"
                                        class="btn btn-sm btn-info position-relative text-lg-center">
                                        <i class="bi bi-eye"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{App\Models\Comment::where('thesis_id',$thesis->id)->where('user_id','!=',Auth::id())->count()}}
                                        </span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- New Modal -->
<x-modal id="myModal" title="<i class='bi bi-plus'></i>د رسالې د حالت تغیر">
    <form id="frmUpdate" action="" method="post">
        @csrf
        @method('put')
        <div class="form-group mb-3">
            <label for="status">حالت</label>
            <select name="status" id="status" class="form-control">
                <option value="0">انتظار</option>
                <option value="1">قبول</option>
                <option value="2">رد</option>
            </select>
        </div>
        <x-input type="hidden" name="marks" label="نمبرې" />
        <x-buttons.save />
    </form>
</x-modal>
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('admin/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
    $('.data-table').DataTable();

    $(document).on("click",'.btn-status',function() {
        var route=$(this).attr('upadate-route');
        var currentStatus=$(this).attr('current-status');
        $("#status").val(currentStatus);
        $("#frmUpdate").attr('action',route);
    });
    $("#status").change(function(){
        if($(this).val()==1){
            $("#marks").attr('type','number');
        }else{
            $("#marks").attr('type','hidden');
            $("#marks").val(0);
        }
    });
</script>
