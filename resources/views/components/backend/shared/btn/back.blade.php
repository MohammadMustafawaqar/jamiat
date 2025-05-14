@props([
    'route'=>'default',    
    'param'=>'0'    
])
<div style="display:inline-block">

    <a @if ($param == 0) href="{{ route($route) }}" @else href="{{ route($route, $param) }}" @endif class="btn" style="background: #ccc">
        <i class="fa fa-arrow-{{ app()->getLocale() == 'en' ? 'left' : 'right' }}"></i>
        {{ Settings::trans('Back', 'مخکنې پاڼه', 'صفحه قبلي', 'رجوع') }}
    </a>
