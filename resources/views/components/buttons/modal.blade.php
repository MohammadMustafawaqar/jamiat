@props([
'modal' => '',
'text' => '',
'class'=>'',
'type' => 'primary'
])
<button  {{ $attributes }} class="btn btn-{{ $type }} {{$class}}" data-bs-toggle="modal" data-bs-target="#{{$modal}}">
    {!!$text!!}
</button>