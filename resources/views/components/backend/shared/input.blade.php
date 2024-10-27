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

<div class="{{ $col }} mb-2">
    <div class="form-group">
        @if($label!='')
        <label class="mb-0" for="{{ $id == '' ? $name : $id }}">{{ $label }} {!! $required==1 ? '<i
                class="text-danger">*</i>' : '' !!}</label>
        @endif
        <input {{ $attributes }} type="{{$type}}" class="{{ $classes }} @error($name) is-invalid @enderror"
            id="{{ $id == '' ? $name : $id }}" value="{{ $value ? $value : old($name) }}" name="{{ $name }}" key="{{ $name }}">
        @error($name)
        <span id="{{ $id == '' ? $name : $id }}-error" class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>