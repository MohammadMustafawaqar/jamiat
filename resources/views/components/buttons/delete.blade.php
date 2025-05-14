@props([
'route' => '',
'title' => ''
 ])
<button class="btn btn-sm btn-danger btn-delete" title="Delete" route="{{ $route }}">
    <i class="bi bi-trash"></i>
    {{ $title }}
