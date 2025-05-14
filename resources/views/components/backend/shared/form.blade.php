<div>
    <form action="{{ $route!='' ? route($route) : $url }}" method="{{ $method }}" enctype= multipart/form-data>
        @if($method=='post')
            @csrf
        @endif

        {{ $slot }}
    </form>
