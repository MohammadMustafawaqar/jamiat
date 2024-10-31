@props([
   'color'=>'text-white'
])
<div style="display:inline;">
    <div {{ $attributes }} class="spinner-border spinner-border-sm {{ $color }}" role="status">
      <span class="sr-only">Loading...</span>
    </div>
</div>