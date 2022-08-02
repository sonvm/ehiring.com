<?php

$name = $applicant->name;
$bod = $applicant->bod;
$bod = date("Y-m-d", strtotime($bod));
$address = $applicant->address;
$phone = $applicant->phone;
$gpa = $applicant->gpa;

?>

@extends('layouts.default')

@section('title', 'Applicant'.$name)

@section('page-header', 'Applicant infos')

@section('content')


<div class="row">
    <div>
        <h3>Basic Info</h3>
        <ul>
            <li>Name: {{$name}}</li>
            <li>Birthday: {{$bod}}</li>
            <li>Grade Point Average: {{$gpa}}</li>
            <li>Phone: {{$phone}}</li>
            <li>Address: {{$address}}</li>
        </ul>
    </div>

    <div>
        <h3>System's Grading</h3>
    </div>

    <div>
        <h3>Hiring Board's Grading</h3>
    </div>

    <div>
        <h3>Ranking</h3>
    </div>

</div>
</div>


<!-- <div class="form-group row">
      <label for="user" class="col-sm-2 col-form-label">User</label>
      <div class="col-sm-10">
        <input type="text" readonly="" class="form-control-plaintext" name="user" value="email@example.com">
      </div>
    </div> -->

@endsection