<div>
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <i class="icon fas fa-check"></i> &nbsp; {{ session('success') }}
    </div>
    @endif
