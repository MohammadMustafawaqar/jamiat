@if ($errors->any())
<div class="alert alert-danger alert-dismissible">
  <button type="button" class="btn-close" data-dismiss="alert" aria-hidden="true"></button>
  <h5><i class="icon fas fa-ban"></i> {{ __('messages.validation_error') }}!</h5>
        @foreach ($errors->all() as $error)
            <p class="mb-0 pl-5">{{ $error }}</p>
        @endforeach
</div>
@endif

