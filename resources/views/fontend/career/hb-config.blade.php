@extends('layouts.default')

@section('title', 'Hiring Board Config')

@section('page-header', 'Hiring Board Config')
@section('content')

<?php 
$existed = session('existed');
?>

@include('layouts.message')

<div class="row">

    <div class="col-10 list-group mx-0 row">
        <h3>Search</h3>

        <div class="col-7">
        {!! Form::open(array('url' => '/careers/'.$id.'/hiring-board/search', 'class' => 'form-horizontal','method' => 'get')) !!}
            <div class="input-group">
                <input name="search_users" type="text" class="form-control" placeholder="Add a new member" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
            </div>
            {!! Form::close() !!}
        </div>

        @if(isset($results))
            @if($results->count()==0)
                <div class="alert alert-danger" role="alert">No results.</div>
            @endif
            @foreach($results as $result)
            <br>
                <div class="row">
                    <div class="col">{{$result->name}}</div>
                    <a type="button" class="btn btn-success col-2 px-2 mx-1" href="/careers/{{$id}}/hiring-board/add/{{$result->id}}">Add User</a>
                </div>
                <br>
            @endforeach
        @endif

        <h3>Current</h3>

        @if(isset($users))
            @if($users->count()==0)
                <div class="alert alert-warning" role="alert">Hiring Board is currently empty.</div>
            @else
            @foreach($users as $user)
            <br>
                <div class="row">
                    <div class="col"><?php echo $user->name;?></div>
                    <a type="button" class="btn btn-primary col-2 px-2 mx-1" href="/careers/{{$id}}/applicants/rating/{{$user->id}}">Check Ratings</a>
                    <a type="button" class="btn btn-danger col-2 px-2 mx-1" href="/careers/{{$id}}/hiring-board/remove/{{$user->id}}">Remove</a>
                </div>
                <br>
            @endforeach
            @endif
        @endif


    </div>

    </div>




</div>


@endsection