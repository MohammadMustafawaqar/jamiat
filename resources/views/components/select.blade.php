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
<div class="{{ $col }}">
    <div class="mb-3 has-danger">
        @if($label!='')
        <label class="mb-1" for="{{ $id == '' ? $name : $id }}">{{ $label }} {!! $required==1 ? '<i
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
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>