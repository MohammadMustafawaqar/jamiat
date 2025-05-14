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
        <label class="mb-0" for="{{ $id == '' ? $name : $id }}">{{ $label }} {!! $required==1 ? '<i
                class="text-danger">*</i>' : '' !!}</label>
        @endif
        <textarea {{ $attributes }} type="{{$type}}" class="{{ $classes }} @error($name) is-invalid @enderror"
            id="{{ $id == '' ? $name : $id }}" name="{{ $name }}">{{ $value ? $value : old($name) }}</textarea>
        @error($name)
        <span id="{{ $id == '' ? $name : $id }}-error" class="error invalid-feedback">{{ $message }}</span>
        @enderror
        <span id="{{ $id == '' ? $name : $id }}-error" class="error invalid-feedback d-none"></span>

    </div>
