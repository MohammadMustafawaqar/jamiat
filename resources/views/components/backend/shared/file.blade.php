@props([
    'label' => 'File',
    'id' => '',
    'name' => '',
    'classes' => '',
    'col' => 'col-sm-12',
])
<div class="form-group {{ $col }}">
    @if ($label != '')
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    {{ $slot }}
    <div class="input-group {{ $slot != '' ? 'mt-1' : '' }} " >
        <div class="custom-file " style="width: 100%">
            <input type="file" class="{{ $classes }} form-control" id="{{ $id == '' ? $name : $id }}"
                name="{{ $name }}" >
        </div>
        @error($name)
            <span id="{{ $id == '' ? $name : $id }}-error"
                class="error invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>
</div>
