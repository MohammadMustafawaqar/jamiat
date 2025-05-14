@push('styles')
<link rel="stylesheet" href="{{asset('admin/css/datatable.css')}}">
@endpush

@push('scripts')
<script type="text/javascript" src="{{asset('admin/js/plugins/jquery.dataTables.min.js')}}"></script>

<script>
    $('.data-table').DataTable();
</script>
