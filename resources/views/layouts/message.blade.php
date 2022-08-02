<?php
$message = session('message');
$existed = session('existed');
$error = session('error');

?>



@if(isset($message))
<div class="alert alert-dismissible alert-success col-8">
    <div class="position-absolute top-0 end-0"><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    {{ $message }}
</div>

@endif


@if(isset($existed))
<div class="alert alert-dismissible alert-warning col-8">
    <div class="position-absolute top-0 end-0"><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    {{ $existed }}
</div>
@endif

@if(isset($error))
<div class="alert alert-dismissible alert-danger col-8">
    <div class="position-absolute top-0 end-0"><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    {{ $error }}
</div>
@endif