<?php
$id = $recruiting->id;
$title = $recruiting->title;
$description = $recruiting->description;
$criteria = $recruiting->criteria;
$start = $recruiting->starting_date;
$end = $recruiting->closing_date;

$start = date("Y-m-d", strtotime($start));
$end = date("Y-m-d", strtotime($end));

$status = ($recruiting->status) ? 'Active' : 'Closed';
?>

@extends('layouts.default')

@section('title', 'Edit')

@section('page-header', 'Edit')

@section('content')
@include('layouts.message')


@if (count($errors) > 0)
<div class="alert alert-danger">
   Invalid Inputs:
   <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
   </ul>
</div>
@endif

{!! Form::open(array('url' => '/careers/'.$id, 'class' => 'form-horizontal','method' => 'put')) !!}

<!-- <div class="form-group row">
      <label for="user" class="col-sm-2 col-form-label">User</label>
      <div class="col-sm-10">
        <input type="text" readonly="" class="form-control-plaintext" name="user" value="email@example.com">
      </div>
    </div> -->

<div class="form-group">
   {!! Form::label('title', 'Title', array('class' => 'col-sm-3 control-label')) !!}
   <div class="col-sm-12">
      {!! Form::text('title', $title, array('class' => 'form-control')) !!}
   </div>
</div>
<br>

<div class="form-group">
   {!! Form::label('description', 'Job\'s description', array('class' => 'col-sm-3 control-label')) !!}
   <div class="col-sm-12">
      {!! Form::textarea('description', $description, array('class' => 'form-control')) !!}
   </div>
</div>
<br>

<div class="form-group">
   {!! Form::label('criteria', 'Criteria Number', array('class' => 'col-sm-3 control-label')) !!}
   <div class="col-sm-4">
      {!! Form::number('criteria', $criteria, array('class' => 'form-control')) !!}
   </div>
</div>
<br>

<div class="form-group">
   {!! Form::label('startDate', 'Starting Date', array('class' => 'col-sm-3 control-label')) !!}
   <div class="col-sm-12">
      {!! Form::date('startDate', $start, array('class' => 'form-control')) !!}
   </div>
</div>
<br>

<div class="form-group">
   {!! Form::label('endDate', 'Ending Date', array('class' => 'col-sm-3 control-label')) !!}
   <div class="col-sm-12">
      {!! Form::date('endDate', $end, array('class' => 'form-control')) !!}
   </div>
</div>
<br>

<fieldset>
   <legend class="mt-4">Status</legend>
   <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" name="status" checked="">
      <label class="form-check-label" for="flexSwitchCheckChecked">Active</label>
   </div>
</fieldset>
<br>

<br>

<div class="form-group d-grid gap-2 col-3 mx-auto">
   <button type="submit" class="btn btn-primary">Finish</button>
</div>
{!! Form::close() !!}
</table>

</fieldset>
</form>
@endsection