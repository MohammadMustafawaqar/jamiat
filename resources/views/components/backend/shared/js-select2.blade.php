@props([
    'name' => 'default_name',
    'id' => 'default_id',
    'list' => [],
    'value' => 'value',
    'selected_value' => 'selected_value',
    'text' => 'text',
    'default' => 'default',
    'label' => 'default',
    'col' => 'col-sm-12',
    'required' => '0',
    'disabled' => '0',
    'readonly' => '0',
    'classes' => 'form-control',
    'modal_id' => 'create-modal',
    'style' => '',
])
@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/select2/css/select2-bootstrap-5-theme.min.css') }}">
@endpush
<div class="{{ $col }} mb-2" style="{{ $style }}">
    <div class="form-group was-validated">

        @if ($label != 'default')
            <label for="{{ $id }}" class="mb-0">
                {{ $label }}
                {!! $required == 1 ? '<i class="text-danger">*</i>' : '' !!}
            </label>
        @endif
        <select {{ $attributes }} name="{{ $name }}" id="{{ $id }}" class="{{ $classes }} "
            @if ($disabled) disabled @endif @if ($readonly) readonly @endif
            style="width: 100%" @required($required)>
            <option value="">{{ $default }}</option>
            @foreach ($list as $item)
                <option value="{{ $item->$value }}" @selected($item->$value == $selected_value || old($name) == $item->$value || (isset($_GET[$name]) && $_GET[$name] == $item->$value))>{{ $item->$text }}
                </option>
            @endforeach
        </select>
        <span id="{{ $id == '' ? $name : $id }}-error" class="error invalid-feedback d-none"></span>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('admin/select2/js/select2.full.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#{{ $id }}').select2({
                theme: "bootstrap-5",
                placeholder: '{{ $default }}',
                dropdownParent: $('#{{ $modal_id }}')
            });
        });
    </script>
@endpush
