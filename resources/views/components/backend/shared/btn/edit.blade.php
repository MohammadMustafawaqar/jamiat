<div style="display:inline;">
    @props([
    'route'=>'',
    'param'=>'',
    'classes'=>'btn btn-info btn-sm'
    ])
    <a {{ $attributes }} href="{{ route($route,$param) }}" class="{{ $classes }}">
        @if($slot=='')
        <i class="fa fa-edit"></i>
        @else
        {{ $slot }}
        @endif
    </a>
