@props([
'id'=>'modalDefaultId',
'classes'=>'',
'title'=>'Modal Default Title (use "title" property to replace title)',
// Size Added By Mustafa
'size' => ''
])

<div>
  <div wire:ignore.self {{ $attributes }} class="modal fade {{ $classes }}" id="{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modal-{{ $size }}" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="px-2">
          {{-- <x-backend.shared.alert.success /> --}}
          <x-backend.shared.alert.error />
          <x-backend.shared.validation.all />
        </div>
        {{ $slot }}
      </div>
    </div>
  </div>
  <!-- End of Add Model -->
</div>