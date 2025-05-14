@props([
'col' => 'col-sm-6',
'id' => 'id',
'name' => 'name',
'label' => 'Text Editor',
'containerClass' => '',
'classes' => '',
])
<div class="{{ $col }}  px-2 {{ $containerClass }}">
    <label for="{{ $id }}">{{ $label }}</label>
    <textarea id='{{ $id }}' class="{{ $classes }}" {{ $attributes }} name='{{ $name }}'></textarea>
</div>

@push('scripts')
<script>
    $(document).ready(function(){
        var config = {
            placeholder: '...',
            tabsize: 2,
            height: 100,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear', 'fontsize', 'subscript', 'superscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'help']]
            ],
    }
        $('#{{ $id }}').summernote({
            ...config,
        });
     });
</script>

