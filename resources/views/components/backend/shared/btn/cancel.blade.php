@props([
    'id' => ''
])
<button class="btn btn-danger" id='{{ $id }}' type="button">
    <i class="fa fa-cancel"></i>
    {{ __('lang.cancel') }}
