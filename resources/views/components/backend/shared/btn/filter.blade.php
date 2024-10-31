<button type="submit" {{ $attributes }} class="btn btn-primary px-2 rounded rounded-md">
    <i class="fa fa-filter"></i>&nbsp;
    {{ __('applicant.filter')}}
    <x-loader wire:loading />
</button>