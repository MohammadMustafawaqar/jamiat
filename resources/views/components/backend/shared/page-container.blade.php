@props([
    'card_type' => 'card-primary',
])

<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <x-backend.shared.validation.all />
                    </div>
                    <div class="card-body" style="min-height: 70vh">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
