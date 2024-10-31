@extends('layouts.app')
@section('title','Topics')
@push('styles')
<link rel="stylesheet" href="{{asset('admin/css/datatable.css')}}">
@endpush

@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title"><i class="bi bi-list-ul"></i> {{__('lang.topics')}}</h3>
            </div>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-striped data-table">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>{{__('lang.form_id')}}</th>
                                <th>{{__('lang.student')}}</th>
                                <th>{{__('lang.title')}}</th>
                                <th>حالت</th>
                                <th>ملاحضات</th>
                                <th>Created at</th>
                                <th>{{__('lang.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topics as $topic)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$topic->user?->student?->form_id}}</td>
                                <td>{{$topic->user?->student?->full_name}}</td>
                                <td>{{$topic->title}}</td>
                                <td>
                                    {!! $topic->status->label() !!}
                                </td>
                                <td>{{$topic->remarks}}</td>
                                <td>{{$topic->created_at->diffForHumans()}}</td>
                                <td>
                                    <x-buttons.modal class="btn-status" upadate-route="{{route('topic.update',$topic)}}"
                                        current-status="{{$topic->status->value}}" modal="myModal" text="تغیر حالت" />
                                    @if ($topic->fee)
                                    <span class="me-1 badge bg-success fee-slip"
                                        show-route="{{route('topic.show',$topic)}}">فیس رسید</span>
                                    @else
                                    @if ($topic->status->value=="1")
                                    <x-buttons.modal class="btn-fee" topic-id="{{$topic->id}}" modal="feeModal"
                                        text="فیس جمع کول" />
                                    @else
                                    <span class="me-1 badge bg-secondary">انتظار</span>
                                    @endif
                                    @endif

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

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
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('admin/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
    $('.data-table').DataTable();
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