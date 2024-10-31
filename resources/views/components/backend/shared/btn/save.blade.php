<div style="display:inline-block">
    <button type="submit" {{ $attributes }} class="btn btn-primary save-btn">
        @if(app()->getLocale()=='en')
            <i class="fa fa-save save-icon"></i> 
            <i class="fa fa-spinner fa-spin spinner-icon" style="display: none"></i>
            &nbsp;
        @endif
        {{ Settings::trans('Save','ثبت','ثبت') }}
        @if(app()->getLocale()!='en')
            <i class="fa fa-save save-icon"></i> 
            <i class="fa fa-spinner fa-spin spinner-icon" style="display: none"></i>
            &nbsp;
        @endif
    </button>
</div>
