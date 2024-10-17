@props([
'modal' => '',
'text' => '',
'class'=>''
])
<button  {{ $attributes }} class="btn btn-primary {{$class}}" data-bs-toggle="modal" data-bs-target="#{{$modal}}">
    {!!$text!!}
</button>