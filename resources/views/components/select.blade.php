@props([
'options' => [],
'id' => '',
'label' => '',
'class' => 'form-control',
'name' => '',
'col' => 'col-sm-12',
'required' => '0',
'display'=>'name',
'selected'=>''
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/select2/css/select2-bootstrap-5-theme.min.css') }}">
    
@endpush
<div class="{{ $col }}" style="z-index: 1">
    <div class="has-danger">
        @if($label!='')
        <label class="mb-0" for="{{ $id == '' ? $name : $id }}">{{ $label }} {!! $required==1 ? '<i
                class="text-danger">*</i>' : '' !!}</label>
        @endif
        <select class="{{ $class }} @error($name) is-invalid @enderror" name="{{ $name }}"
            id="{{ $id == '' ? $name : $id }}" style="width: 100%;" {{ $attributes }}>
            <option value=""></option>
            @foreach ($options as $option)
            <option value="{{$option->id}}" {{ $selected==$option->id?'selected':(old($name)==$option->id ? 'selected' :
                '')}}>
                @if ($option->form_id)
                    {{$option->form_id}} - 
                @endif
                {{$option->$display}}
            </option>
            @endforeach
        </select>
        @error($name)
        <span class="form-control-feedback" role="alert">
            <strong class="text-danger">{{ $message }}</strong>
        </span>
        @enderror
        <span id="{{ $id == '' ? $name : $id }}-error" class="error invalid-feedback d-none"></span>
    </div>
</div>
