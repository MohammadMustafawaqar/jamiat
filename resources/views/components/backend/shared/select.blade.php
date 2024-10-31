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

<div class="{{ $col }}">
    <div class="form-group">
        @if ($label != 'default')
            <label for="{{ $id }}" class="mb-0">{{ $label }} {!! $required == 1 ? '<i class="text-danger">*</i>' : '' !!}</label>
        @endif
        <select {{ $attributes }} name="{{ $name }}" id="{{ $id }}" style="width: 100%"
            class="{{ $classes }} @error($name) is-invalid @enderror"
            @if ($disabled) disabled @endif @if ($readonly) readonly @endif>
            <option value="">{{ $default }}</option>
            @foreach ($list as $item)
                <option value="{{ $item->$value }}" @if ($item->$value == $selected_value) selected @endif>{{ $item->$text }}
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
                placeholder: '{{ $default }}'
            });
        });
    </script>
@endpush
