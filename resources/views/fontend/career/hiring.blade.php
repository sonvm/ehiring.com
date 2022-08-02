<?php $position_header = ($position->title); ?>

@extends('layouts.default')

@section('title', 'Hiring')

@section('page-header', 'Applicants applied for: ')
@section('page-header-2', $position_header)
@section('content')

<?php

if (!isset($done))
$message = session('message');
else $message=$done;

$error = session('error');
?>
@include('layouts.message')

<?php
$passed = 0;
foreach ($cvs as $cv) {
    if ($cv->status == "passed") $passed++;
}
?>

<div class="row">

    @if($cvs->count()==0)
    <div class="alert alert-danger">
        There isn't any applicants yet
    </div>

    @else

    <div>
        <span>Hiring's Criteria: </span>
        <span>{{$passed}}/{{$position->criteria}}</span>

    </div>


    <div class="col-10 list-group mx-0">
        {!! Form::open(array('url' => '/careers/'.$position->id.'/hiring/finish', 'class' => 'form-horizontal','method' => 'get')) !!}

        @if(!isset($done))
        @foreach($cvs as $cv)
        <?php
        $id = $cv->id;
        $name = $cv->name;
        $bod = $cv->bod;
        $bod = date("Y-m-d", strtotime($bod));
        $gpa = $cv->gpa;
        $status = $cv->status;

        ?>
        <div class="p-2 my-1 rounded text-dark row">
            <div class="col-1 row">
                <div class="align-self-center justify-content-center">
                    @if($status!='passed')
                    <input class="form-check-input" type="checkbox" value="{{$id}}" name="canidate_{{$id}}">
                    @else
                    <input class="form-check-input" type="checkbox" value="{{$id}}" name="canidate_{{$id}}" checked>
                    @endif
                </div>

            </div>

            <div class="col-11">
                <a href="/applicant/{{$id}}" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <div class="d-flex w-100 justify-content-between">
                        <div class="col-sm-7">

                            <ul>
                                <li>Name: {{$name}}</li>
                                <li>Birthday: {{$bod}}</li>
                                <li>Grade Point Average: {{$gpa}}</li>
                            </ul>
                        </div>
                    </div>
                </a>
            </div>
        </div>




        @endforeach

        <div class="d-flex justify-content-center">
            <button class="btn btn-primary" type="submit" id="button-addon2">Save</button>
        </div>

        {!! Form::close() !!}


        <div class="d-flex justify-content-center">
            @if ($cvs->lastPage() > 1)
            <ul class="pagination">

                <li>

                    @if( $cvs->currentPage() != 1)

                <li class="page-item">
                    <a class="page-link" href="{{ $cvs->url(1) }}">«</a>
                </li>
                @endif

                @if( ($news->currentPage() <= 2)) @for ($i=1; $i <=5; $i++) @if($i<=$cvs->lastPage())
                    <li class="page-item {{ ($i==$cvs->currentPage()) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $cvs->url($i) }}">{{ $i }}</a>
                    </li>
                    @endif
                    @endfor
                    @elseif(($cvs->currentPage() >= $cvs->lastPage()-1))
                    @for ($i = $cvs->lastPage()-4; $i <=$cvs->lastPage(); $i++)
                        @if($i>=1)
                        <li class="page-item {{ ($i==$cvs->currentPage()) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $cvs->url($i) }}">{{ $i }}</a>
                        </li>
                        @endif
                        @endfor
                        @else
                        @for ($i = -2; $i <=2; $i++) <li class="page-item {{ ($i==0) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $cvs->url($cvs->currentPage()+$i) }}">{{ $cvs->currentPage()+$i }}</a>
                            </li>
                            @endfor
                            @endif

                            @if($cvs->currentPage() != $cvs->lastPage())

                            <li class="page-item">
                                <a class="page-link" href="{{ $cvs->url($cvs->lastPage()) }}">»</a>
                            </li>
                            @endif
                            </li>
            </ul>
            @endif
        </div>

        @endif
    </div>



    <div class="col-2 p-3 my-1">
        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        <br>
        <div>Filter</div>
        <div class="list-group mx-0 w-auto">
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="">
                <span>
                    First checkbox
                </span>
            </label>

            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="">
                <span>
                    First checkbox
                </span>
            </label>

            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="">
                <span>
                    First checkbox
                </span>
            </label>

        </div>

        <div>Sort</div>
        <div class="list-group mx-0 w-auto">
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="">
                <span>
                    Ranking
                </span>
            </label>
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="">
                <span>
                    System's Score
                </span>
            </label>

            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="">
                <span>
                    Hiring Board's Score
                </span>
            </label>



        </div>
    </div>

    @endif


</div>


@endsection