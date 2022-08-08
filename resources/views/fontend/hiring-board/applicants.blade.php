<?php $position = ($position->title); ?>

@extends('layouts.default')

@section('title', 'Applicants List')

@section('page-header', 'Applicants applied for: ')
@section('page-header-2', $position)
@section('content')

<div class="row">

    @if($cvs->count()==0)
    <div class="alert alert-danger">
        There isn't any applicants yet
    </div>

    @else

    <div class="col-10 list-group mx-0">

        @foreach($cvs as $cv)
        <?php
        $id = $cv->id;
        $name = $cv->name;
        $bod = $cv->bod;
        $bod = date("Y-m-d", strtotime($bod));
        $gpa = $cv->gpa;

        ?>
        <div class="p-2 my-1 rounded text-dark">
            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex w-100 justify-content-between">
                    <div class="col-sm-7">

                        <ul>
                            <li>Name: {{$name}}</li>
                            <li>Birthday: {{$bod}}</li>
                            <li>Grade Point Average: {{$gpa}}</li>
                        </ul>
                    </div>

                    <div class="position-relative align-baseline ">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item rounded-2 " href="/applicant/{{$id}}" >Info</a></li>
                                <li><a href="/careers/{{$rid}}/applicants/{{$id}}/rate" class="dropdown-item rounded-2 ">Rate</a></li>
                            </ul>
                        </div>
                    </div>




                </div>
</div>

                
            </div>




            @endforeach

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
        </div>



        <div class="col-2 p-3 my-1">
        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        <br>

        <div>Sort</div>
        <div class="list-group mx-0 w-auto">
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="radio" value="" >
                <span>
                    Newest
                </span>
            </label>
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="radio" value="" checked="">
                <span>
                    Oldest
                </span>
            </label>
        </div>

        <div>Filter</div>
        <div class="list-group mx-0 w-auto">
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="radio" value="" checked="">
                <span>
                    All
                </span>
            </label>

            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="radio" value="" >
                <span>
                    Rated
                </span>
            </label>

            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="radio" value="" >
                <span>
                    Not rated
                </span>
            </label>

        </div>
        </div>

        @endif


    </div>


    @endsection