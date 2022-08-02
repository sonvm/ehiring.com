<?php
    $id=$recruiting->id;
    $title=$recruiting->title;
    $description=$recruiting->description;
    $criteria=$recruiting->criteria;
    $start=$recruiting->starting_date;
    $end=$recruiting->closing_date;

    $start=date("Y-m-d",strtotime($start));
    $end=date("Y-m-d",strtotime($end));

    $status=($recruiting->status)?'Active':'Closed';

?>

@extends('layouts.default')

@section('title', $title)

@section('page-header', $title)

@section('content')


    <div class="row">



    <div class="col-9 list-group mx-0">
            <div class="p-2 my-1 rounded text-dark">

                    <div class="d-flex w-100 justify-content-between">
                            <p class="mb-0 opacity-75" style="white-space: break-spaces;">{{$description}}</p>
                    </div>

            </div>
    </div>

        <div class="col-3 p-3 my-1 rounded text-secondary" style="background-color:lightgray;height:200px"> 
            <div class="d-grid gap-2 w-fluid mx-auto">
                <a class="btn btn-primary" href="<?php echo (url()->current().'/apply');?>">Apply Now</a>
            </div>
            <br>

        <div class="my-1">
            <span class="col-5">Duration: </span>
            <span class="col-7">{{$start}} - {{$end}}</span>
        </div>

        <div class="my-1">
            <span class="col-5">Number: </span>
            <span class="justify-end">{{$criteria}}</span>
        </div>

        <div class="my-1">
            <span class="col-5">Status: </span>
            @if($status=='Active')
            <span class="col-7 rounded bg-success text-light px-1">{{$status}}</span>
            @else
            <span class="col-7 rounded bg-warning text-light px-1">{{$status}}</span>
            @endif
        </div>
        
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