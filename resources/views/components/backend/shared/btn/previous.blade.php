<button class="btn
btn-secondary" wire:click="back" type="button">
    <i class="fa fa-arrow-{{ (app()->getLocale() == 'en') ? 'left' : 'right' }}"></i>
    &nbsp;
    {{ __('applicant.previous') }}
</button>