@props([
    'route' => '',
    'params' => '0',
    'classes' => ''
    ])
<div class="d-inline">

    <a @if($params==0) href="{{ route($route) }}" @else href="{{ route($route,['params' => $params]) }}" @endif {{ $attributes }} class="btn btn-info {{ $classes }}"  id='print-btn' target="_blank">
        <i class="fa fa-print"></i>
        {{ Settings::trans('Print', 'پرنټ', 'پرنت') }}
    </a>
</div>