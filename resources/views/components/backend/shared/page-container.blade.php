@props([
    'card_type' => 'card-primary',
])

<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="tile">
                    <div class="tile-title">
                        {{-- <x-backend.shared.validation.all /> --}}
                    </div>
                    <div class="tile-body" style="min-height: 70vh">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
