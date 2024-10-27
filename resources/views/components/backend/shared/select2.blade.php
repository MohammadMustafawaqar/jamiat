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
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/select2/css/select2-bootstrap-5-theme.min.css') }}">
    
@endpush
<div class="{{ $col }}">
    <div class="form-group">

        @if ($label != 'default')
            <label for="{{ $id }}" class="mb-0">{{ $label }} {!! $required == 1
                ? '<i
                            class="text-danger">*</i>'
                : '' !!}</label>
        @endif
        <select {{ $attributes }} name="{{ $name }}" id="{{ $id }}"
            class="{{ $classes }} @error($name) is-invalid @enderror" style="width: 100%"
            @if ($disabled) disabled @endif @if ($readonly) readonly @endif>
            <option value="">{{ $default }}</option>
            @foreach ($list as $item)
                <option value="{{ $item->$value }}" @selected($item->$value == $selected_value || old($name) == $item->$value || (isset($_GET[$name]) && $_GET[$name] == $item->$value))>{{ $item->$text }}
                </option>
            @endforeach
        </select>
        @error($name)
            <span id="{{ $id == '' ? $name : $id }}-error" class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

@push('scripts')
    <script>
         $(document).ready(function() {
            $('#{{ $id }}').select2({
                theme: "bootstrap-5",
                placeholder: '{{ $default }}',
            });
        });
    </script>
@endpush
