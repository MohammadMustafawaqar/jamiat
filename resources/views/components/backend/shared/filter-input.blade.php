@props([
'id' => '',
'label' => '',
'type' => 'text',
'classes' => 'form-control',
'value' => '',
'name' => '',
'col' => 'col-sm-12',
'required' => '0',

])

<div class="{{ $col }}">
    <div class="form-group">
        @if($label!='')
        <label class="mb-0" for="{{ $name }}">{{ $label }}</label>
        @endif
        <input {{ $attributes }} type="{{$type}}" class="{{ $classes }} @error($name) is-invalid @enderror"
            id="{{ $name }}" value="{{ isset($_GET[$name]) ? $_GET[$name] : '' }}" name="{{ $name }}" key="{{ $name }}">
        <span id="{{ $name }}-error" class="error invalid-feedback d-none"></span>
    </div>
</div>