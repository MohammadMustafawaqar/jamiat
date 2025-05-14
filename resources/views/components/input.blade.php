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
    <div class="mb-3 has-danger">
        @if($label!='')
        <label class="mb-0" for="{{ $id == '' ? $name : $id }}">{{ $label }} {!! $required==1 ? '<i
                class="text-danger">*</i>' : '' !!}</label>
        @endif
        @if($type=='textarea')
        <textarea {{ $attributes }} class="{{ $classes }} @error($name) is-invalid @enderror" name="{{ $name }}"
            id="{{ $id == '' ? $name : $id }}" rows="4"
            placeholder="{{ $label }}...">{{$value ? $value : old($name)}}</textarea>
        @else
        <input {{ $attributes }} type="{{$type}}" class="{{ $classes }} @error($name) is-invalid @enderror"
            id="{{ $id == '' ? $name : $id }}"
            value="{{ isset($_GET[$name]) ? $_GET[$name] : ( $value ? $value : old($name) ) }}" name="{{ $name }}"
            key="{{ $name }}" placeholder="{{ $label }}...">
        @endif
        @error($name)
        <span class="form-control-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
