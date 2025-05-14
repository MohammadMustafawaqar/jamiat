@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <i class="icon fa fa-times"></i> &nbsp; {{ session('error') }}
</div>
