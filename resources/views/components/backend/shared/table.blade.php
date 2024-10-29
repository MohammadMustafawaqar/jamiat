@props([
    'classes' => '',
    'max_height' => '',
    'id' => ''
])

<div>
    <div class="container-fluid d-flex justify-content-between py-3">
        {{ $tools }}
    </div>
    <div class="table-responsive" style="min-height: 50vh; max-height: {{ $max_height }}">
        <table class="table table-striped table-hover {{ $classes }}" id='{{ $id }}'>
            {{ $slot }}
        </table>
        {{ $links }}
    </div>
</div>


