@props([
'id' => '',
'title' => '',
'size'=>''
])
<div class="modal animate__animated animate__zoomIn animate__faster" id="{{$id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-{{$size}}">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    {!!$title!!}
                </h1>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{$slot}}
            </div>
        </div>
    </div>
</div>