
@props([
  'title' => 'title',
  'icon' => ''
])
<div class="app-title" style="z-index: -9;">
  <div>
      <h1>
        <i class="fa fa-{{ $icon }} "></i>
        {{ $title}}</h1>
      {{-- <p>Start a beautiful journey here</p> --}}
  </div>
  <ul class="app-breadcrumb breadcrumb">
      {{$slot}}
  </ul>
</div>