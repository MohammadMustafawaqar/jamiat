@props([
    'id' => '',
    'label' => '',
    'value' => '',
    'name' => '',
    'classes' => '',
    'col' => 'col-sm-12',
])

<div class="{{ $col }}">
    <div class="custom-control custom-checkbox">
        <input  class="custom-control-input {{ $classes }} @error($name) is-invalid @enderror" 
                type="checkbox" 
                id="{{ $id == '' ? $name : $id }}"
                name="{{ $name }}"
                value="{{ $value }}"
                {{ $attributes }} >
        <label for="{{ $id == '' ? $name : $id }}" class="custom-control-label">{{ $label }}</label>
    </div>
