@extends('layouts.default')

@section('title', 'My CVs')

@section('page-header', 'My CVs ')
@section('content')

<div class="row">

    @if($cvs->count()==0)
    <div class="alert alert-danger">
        There isn't any CVs yet
    </div>

    @else

    <div class="col-10 list-group mx-0">

        @foreach($cvs as $cv)
        <?php
        $cv_id = $cv->id;
        $new = $cv->position;

        $news_id = $new->id;
        $title = $new->title;
        $description = $new->description;
        $criteria = $new->criteria;
        $start = $new->starting_date;
        $end = $new->closing_date;

        $start = date("Y-m-d", strtotime($start));
        $end = date("Y-m-d", strtotime($end));

        $status = ($cv->status);

        ?>
        <div class="p-2 my-1 rounded text-dark">

            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex w-100 justify-content-between">
                    <div class="col-sm-7">
                        <h3 class="mb-0">{{$title}}</h3>
                        <p class="mb-0 opacity-75 text-truncate" style=" height:50px; white-space: break-spaces; overflow: hidden; display: none;">{{$description}}</p>
                    </div>
                    <div class="col-sm-3">
                        <div>{{$start}} - {{$end}}</div>
                        <div class="my-1">
                            <div>
                                <span class="col-5">CV's status: </span>
                                @if($status=='applied')
                                <span class="col-7 rounded bg-info text-light px-1">{{$status}}</span>
                                @elseif($status=='passed')
                                <span class="col-7 rounded bg-success text-light px-1">{{$status}}</span>
                                @else
                                <span class="col-7 rounded bg-danger text-light px-1">{{$status}}</span>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="position-relative align-baseline ">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item rounded-2 " href="{{ '/careers/' . $new->id.''}}">Recruiting Info</a></li>
                                <li><a class="dropdown-item rounded-2 " href="{{ '/my-cv/' . $new->id.''}}">Applied CV</a></li>
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

                @if( ($cvs->currentPage() <= 2)) @for ($i=1; $i <=5; $i++) @if($i<=$cvs->lastPage())
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
                    Applied
                </span>
            </label>

            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="radio" value="" >
                <span>
                    Passed
                </span>
            </label>

            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="radio" value="" >
                <span>
                    Failed
                </span>
            </label>

        </div>
    </div>

    @endif


</div>


@endsection