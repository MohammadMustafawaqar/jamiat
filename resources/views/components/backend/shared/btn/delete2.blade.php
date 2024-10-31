@props([
    'route' => 'default',
    'param' => '0'
])
<form method="POST" @if($route !== 'default') action="{{ route($route, $param) }}"@endif onsubmit="return confirmDeletion(event)">
    @csrf
    @method('DELETE')
    <button{{ $attributes }} class="btn btn-danger btn-sm" title="{{ Settings::trans('Delete', 'ډیلیټ', 'حذف') }}">
        <i class="fas fa-trash"></i>
    </button>
</form>

@push('scripts')
<script>
    function confirmDeletion(event) {
        const userConfirmed = confirm("{{ Settings::trans('Are you sure you want to delete this record?', 'ایا غواړی دا ریکارډ ډیلیټ کړئ؟', 'مطمئن هستید که این ریکارد را حذف می نمائید؟') }}");
        if (!userConfirmed) {
            event.preventDefault();
        }
        return userConfirmed;
    }
</script>
@endpush