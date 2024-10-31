@extends('layouts.app')
@section('title','Districts')
@push('styles')
<link rel="stylesheet" href="{{asset('admin/css/datatable.css')}}">
@endpush

@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title"><i class="bi bi-list-ul"></i> {{$province->name}}: {{__('lang.districts')}}</h3>
                <x-buttons.modal modal="myModal" text="<i class='bi bi-plus'></i>" />
            </div>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-striped data-table">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>{{__('lang.name')}}</th>
                                <th>{{__('lang.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($province->districts as $district)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$district->name}}</td>
                                <td>
                                    <div class="btn-group" dir="ltr">
                                        <x-buttons.edit :route="route('district.edit',$district)" />
                                        <x-buttons.delete :route="route('district.destroy',$district)" />
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
    <x-modal id="myModal" title="<i class='bi bi-plus'></i>{{__('lang.district')}}">
        <form action="{{route('district.store')}}" method="post">
            @csrf
            <input type="hidden" name="province_id" value="{{$province->id}}">
            <x-input name="name" :label="__('lang.name')" :required="1" />
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