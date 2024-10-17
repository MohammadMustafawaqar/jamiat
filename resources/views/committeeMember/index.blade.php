@extends('layouts.app')
@section('title','Committee members')
@push('styles')
<link rel="stylesheet" href="{{asset('admin/css/datatable.css')}}">
@endpush

@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title"><i class="bi bi-list-ul"></i> {{__('lang.committee_members')}}</h3>
                <x-buttons.modal modal="myModal" text="<i class='bi bi-plus'></i>" />
            </div>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-striped data-table">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>{{__('lang.name')}}</th>
                                <th>{{__('lang.last_name')}}</th>
                                <th>{{__('lang.father_name')}}</th>
                                <th>{{__('lang.job')}}</th>
                                <th>{{__('lang.phone')}}</th>
                                <th>{{__('lang.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($committeeMembers as $committeeMember)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$committeeMember->name}}</td>
                                <td>{{$committeeMember->last_name}}</td>
                                <td>{{$committeeMember->father_name}}</td>
                                <td>{{$committeeMember->job}}</td>
                                <td>{{$committeeMember->phone}}</td>
                                <td>
                                    <div class="btn-group" dir="ltr">
                                        <x-buttons.delete :route="route('committee-member.destroy',$committeeMember)" />
                                        <x-buttons.edit :route="route('committee-member.edit',$committeeMember)" />
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

    <!-- New Modal -->
    <x-modal id="myModal" title="<i class='bi bi-plus'></i>{{__('lang.committee_member')}}">
        <form action="{{route('committee-member.store')}}" method="post">
            @csrf
            <x-input name="name" :label="__('lang.name')" :required="1" />
            <x-input name="last_name" :label="__('lang.last_name')" :required="1" />
            <x-input name="father_name" :label="__('lang.father_name')" :required="1" />
            <x-input name="job" :label="__('lang.job')" :required="1" />
            <x-input name="phone" :label="__('lang.phone')" :required="1" />
            <x-buttons.save />
        </form>
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
    @if($errors->any())
    const myModal=new bootstrap.Modal("#myModal",{
        keyboard:false
    });
    myModal.show();
    @endif
</script>
@endpush