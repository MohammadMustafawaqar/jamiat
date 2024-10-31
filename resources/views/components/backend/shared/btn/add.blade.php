<div style="display:inline;">
    @props([
        'route' => '',
        'param' => '0',
        'classes' => '',
        'text' =>
            '<i class="fa fa-plus"></i><span class="d-none d-sm-inline-block">&nbsp;Add</span>',
    ])

    <a @if ($param == 0) href="{{ route($route) }}" @else href="{{ route($route, $param) }}" @endif
        {{ $attributes }} class="btn btn-primary {{ $classes }}">
        <i class="fa fa-plus"></i>
        <span class="d-none d-sm-inline-block">
            &nbsp;
            {{ Settings::trans('Add', 'اضافه کړئ', 'اضافه نمائید') }}
        </span>
    </a>
</div>
