@props([
    'id' => '',
    'label' => '',
    'value' => '',
    'name' => '',
    'classes' => '',
    'col' => 'col-sm-12',
    'checked'=>'false'
])

<div class="{{ $col }}">
    <div class="custom-control custom-radio">
        <input class="custom-control-input {{ $classes }} @error($name) is-invalid @enderror"
            type="radio" 
            id="{{ $id == '' ? $name : $id }}" 
            name="{{ $name }}" 
            value="{{ $value }}"
            {{ ($checked) ? 'checked' : '' }}
            {{ $attributes }} >
        <label for="{{ $id == '' ? $name : $id }}" class="custom-control-label">{{ $label }}</label>
    </div>
