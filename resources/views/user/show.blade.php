@extends('layouts.app')
@section('title','User logs('.$user->name.')')
@include('layouts.datatable')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title">User logs({{$user->name}})</h3>
            </div>
            <div class="tile-body">
                <div class="table-responsive">
                    <table id="logsTable" class="table table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>Time</th>
                                <th>Action</th>
                                <th>Model</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('#logsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('users.logs') }}',
            data: function (d) {
                d.user_id = {{$user->id}};
            }
        },
        columns: [
            {
                data: 'created_at',
                name: 'created_at',
                orderable: false,
                render: function (data, type, row) {
                    if (data) {
                        let date = new Date(data);
                        let year = date.getFullYear();
                        let month = ('0' + (date.getMonth() + 1)).slice(-2);
                        let day = ('0' + date.getDate()).slice(-2);
                        let hours = ('0' + date.getHours()).slice(-2);
                        let minutes = ('0' + date.getMinutes()).slice(-2);
                        let seconds = ('0' + date.getSeconds()).slice(-2);
                        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                    }
                    return '';
                },
            },
            { data: 'action', name: 'action',orderable: false, },
            { data: 'model_type', name: 'model_type',orderable: false, },
            { data: 'description', name: 'description', orderable: false, searchable: false }
        ],
    });
</script>
