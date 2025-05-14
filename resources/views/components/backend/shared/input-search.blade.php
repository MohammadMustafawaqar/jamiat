<div>
    <x-backend.shared.form :url="url()->current()">
    <div class="input-group w-100 ml-1">
        <input wire:model="search" type="text" name="search" class="form-control float-right"
         placeholder="Search" @if(isset($_GET['search'])) value="{{ $_GET['search'] }}" @endif>
        <div class="input-group-append">
            <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    </x-backend.shared.from>
