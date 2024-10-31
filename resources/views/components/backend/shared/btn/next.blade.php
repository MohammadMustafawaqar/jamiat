@props([
    'route'=>'default',    
    'param'=>'0'    
])
<div style="display:inline-block">

    <a @if ($param == 0) href="{{ route($route) }}" @else href="{{ route($route, $param) }}" @endif class="btn btn-info" >
        {{ Settings::trans('Next', 'وروستې پاڼه', 'صفحه بعدي') }}
        <i class="fa fa-arrow-{{ app()->getLocale() == 'en' ? 'right' : 'left' }}"></i>
    </a>
</div>