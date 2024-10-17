@extends('layouts.app')
@section('title','Sub categories')
@push('styles')
<link rel="stylesheet" href="{{asset('admin/css/datatable.css')}}">
@endpush

@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title"><i class="bi bi-list-ul"></i> {{$category->name}}: {{__('lang.sub_categories')}}</h3>
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
                            @foreach ($category->subCategories as $subCategory)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$subCategory->name}}</td>
                                <td>
                                    <div class="btn-group" dir="ltr">
                                        <x-buttons.edit :route="route('sub-category.edit',$subCategory)" />
                                        <x-buttons.delete :route="route('sub-category.destroy',$subCategory)" />
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
    <x-modal id="myModal" title="<i class='bi bi-plus'></i>{{__('lang.sub_category')}}">
        <form action="{{route('sub-category.store')}}" method="post">
            @csrf
            <input type="hidden" name="category_id" value="{{$category->id}}">
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