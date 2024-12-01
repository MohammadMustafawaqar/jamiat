@extends('layouts.app')
@section('title','Student')
@push('styles')
<link rel="stylesheet" href="{{asset('admin/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/select2/css/select2-bootstrap-5-theme.min.css')}}">
@endpush
@section('content')

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
            <div class="tile-footer">
                <h3>{{__('lang.supervisor')}}</h3>
                @if($student->supervisors()->exists())
                @php
                $supervisor=$student->supervisors()->orderBy('supervisor_students.created_at', 'desc')->first();
                @endphp
                <table class="table table-sm">
                    <tr>
                        <th>{{__('lang.name')}}</th>
                        <td>{{$supervisor?->name.' '.$supervisor?->last_name}}</td>
                    </tr>
                    <tr>
                        <th>{{__('lang.father_name')}}</th>
                        <td>{{$supervisor?->father_name}}</td>
                    </tr>
                    <tr>
                        <th>{{__('lang.phone')}}</th>
                        <td>{{$supervisor?->phone}}</td>
                    </tr>
                    <tr>
                        <th>{{__('lang.whatsapp')}}</th>
                        <td>{{$supervisor?->whatsapp}}</td>
                    </tr>
                </table>
                @else
                <form action="{{route('supervisor-student.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <x-select class="select2" :options="App\Models\Supervisor::get()" name="supervisor_id"
                            :label="__('lang.supervisor')" :required="1" />
                        <input type="hidden" name="student_id" value="{{$student->id}}">
                        <div>
                            <x-buttons.save />
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="tile">
            <div class="tile-body">
                <h3>{{__('lang.topics')}}</h3>
                @if($student?->user?->topics)
                <div class="accordion" id="accordionExample">
                    @foreach ($student?->user?->topics as $topic)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button @if($loop->iteration!=1)  collapsed @endif" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{$topic->id}}"
                                aria-expanded="@if($loop->iteration==1) true @else false @endif"
                                aria-controls="collapse{{$topic->id}}">
                                {{$topic->title}}
                            </button>
                        </h2>
                        <div id="collapse{{$topic->id}}"
                            class="accordion-collapse collapse @if($loop->iteration==1) show @endif"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <x-buttons.modal class="btn-sm btn-status" upadate-route="{{route('topic.update',$topic)}}"
                                    current-status="{{$topic->status->value}}" modal="myModal" text="تغیر حالت" />
                                @if ($topic->fee)
                                <span class="me-1 badge bg-success fee-slip"
                                    show-route="{{route('topic.show',$topic)}}">فیس رسید</span>
                                @else
                                @if ($topic->status->value=="1")
                                <x-buttons.modal class="btn-sm btn-fee" topic-id="{{$topic->id}}" modal="feeModal"
                                    text="فیس جمع کول" />
                                @endif
                                @endif
                                {!! $topic->status->label() !!}
                                <h3 class="mt-2">{{__('lang.thesis')}}</h3>
                                <table class="table table-sm table-bordered">
                                    <tbody>
                                        @foreach ($topic->theses as $thesis) <tr>
                                            <td>{{$thesis->details}}</td>
                                            <td>
                                                <a href="{{$thesis->file_path}}" target="_blank">
                                                    <i class="bi bi-file-earmark-text text-lg"></i>
                                                </a>
                                            </td>
                                            <td>
                                                {!! $thesis->status->label() !!}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        <div class="tile">
            <div class="tile-body">
                <h3>{{__('lang.committee_members')}}</h3>
                <div class="table-responssive">
                    <table class="table table-sm">
                        <thead class="table-primary">
                            <tr>
                                <th>{{__('lang.name')}}</th>
                                <th>{{__('lang.last_name')}}</th>
                                <th>{{__('lang.father_name')}}</th>
                                <th>{{__('lang.phone')}}</th>
                                <th>{{__('lang.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($student?->supervisors()->exists())
                            <tr>
                                <td>{{$supervisor->name}}</td>
                                <td>{{$supervisor->last_name}}</td>
                                <td>{{$supervisor->father_name}}</td>
                                <td>{{$supervisor->phone}}</td>
                                <td></td>
                            </tr>
                            @endif
                            @foreach ($student->committees as $committee)
                            <tr>
                                <td>{{$committee->name}}</td>
                                <td>{{$committee->last_name}}</td>
                                <td>{{$committee->father_name}}</td>
                                <td>{{$committee->phone}}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- New Modal -->
<x-modal id="myModal" title="<i class='bi bi-plus'></i>د موضوع د حالت تغیر">
    <form id="frmUpdate" action="" method="post">
        @csrf
        @method('put')
        <x-input type="textarea" name="remarks" label="ملاحضات" />
        <div class="form-group mb-3">
            <label for="status">حالت</label>
            <select name="status" id="status" class="form-control">
                <option value="0">انتظار</option>
                <option value="1">قبول</option>
                <option value="2">رد</option>
            </select>
        </div>
        <x-buttons.save />
    </form>
</x-modal>
<!-- Fee Modal -->
<x-modal id="feeModal" title="<i class='bi bi-plus'></i>د فیس جمع کول">
    <form id="frmUpdate" action="{{route('fee.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="topic_id" id="topic_id">
        <x-input type="number" name="amount" label="فیس" required="1" />
        <x-input type="file" name="file_path" label="د فیس رسید" required="1" />
        <x-input type="textarea" name="details" label="ملاحضات" />
        <x-buttons.save />
    </form>
</x-modal>
<!-- Fee show Modal -->
<x-modal id="feeShowModal" size="lg" title="<i class='bi bi-money'></i> جمع شوی فیس">
    <div class="printDiv" dir="rtl"></div>
    <hr>
    <x-buttons.print />
</x-modal>
@endsection


@push('scripts')
<script src="{{asset('admin/select2/js/select2.full.js')}}"></script>
<script type="text/javascript">
    $(".select2").select2({
        placeholder: "{{__('lang.select_option')}}",
        theme: "bootstrap-5"
    });
    $("#myModal").on("shown.bs.modal",function(){
        $("#name").focus();
    });
    $("#feeModal").on("shown.bs.modal",function(){
        $("#amount").focus();
    });
    @if($errors->any())
    const feeModal=new bootstrap.Modal("#feeModal",{
        keyboard:false
    });
    feeModal.show();
    @endif

    $(document).on("click",'.btn-status',function() {
        var route=$(this).attr('upadate-route');
        var currentStatus=$(this).attr('current-status');
        $("#status").val(currentStatus);
        $("#frmUpdate").attr('action',route);
    });
    $(document).on("click",'.btn-fee',function() {
        var topicId=$(this).attr('topic-id');
        $("#topic_id").val(topicId);
    });
    $(document).on("click",'.fee-slip',function() {
        var titleText=$('title').html();
        $('title').html(`${titleText} - Fee Slip`);
        
        var showRoute=$(this).attr('show-route');
        $.ajax({
            url: showRoute,
            method: 'GET',
            success: function(response) {
                $(".printDiv").html(response);
                const feeShowModal=new bootstrap.Modal("#feeShowModal",{
                    keyboard:false
                });
                feeShowModal.show();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

</script>
@endpush