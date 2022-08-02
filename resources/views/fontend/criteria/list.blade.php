@extends('layouts.default')

@section('title', 'Criterias List')

@section('page-header', 'Criterias List')

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


<div>
    <h3>Create a New Criteria</h3>

    <div class="col-7">
        {!! Form::open(array('url' => '/criterias/create', 'class' => 'form-horizontal','method' => 'get')) !!}

        <input name="name" type="text" class="form-control" placeholder="Enter new criteria's name" aria-label="New criteria's name" aria-describedby="button-addon2">

        <div class="form-check form-switch">

            <input class="form-check-input" type="checkbox" name="is_cost_criteria" checked="">
            <label class="form-check-label" for="flexSwitchCheckChecked">Is Cost</label>
        </div>

        <button class="btn btn-primary" type="submit" id="button-addon2">Add Criteria</button>


        {!! Form::close() !!}
    </div>

</div>


<div class="row">



    <div class="col-10 list-group mx-0">
        @foreach($criterias as $criteria)
        <?php
        $id = $criteria->id;
        $name = $criteria->name;
        $is_cost_criteria = ($criteria->is_cost_criteria) ? 'Yes' : 'No';
        ?>
        <div class="p-2 my-1 rounded text-dark">
            <a href="{{ '/criterias/' . $criteria->id}}" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex w-100 justify-content-between">
                    <div class="col-sm-7">
                        <h3 class="mb-0">{{$name}}</h3>
                    </div>
                    <div class="col-sm-3">
                        <div>Is Cost: {{$is_cost_criteria}}</div>
                    </div>
                </div>
            </a>
        </div>





        @endforeach









        <div class="d-flex justify-content-center">
            @if ($criterias->lastPage() > 1)
            <ul class="pagination">

                <li>

                    @if( $criterias->currentPage() != 1)

                <li class="page-item">
                    <a class="page-link" href="{{ $criterias->url(1) }}">«</a>
                </li>
                @endif

                @if( ($criterias->currentPage() <= 2)) @for ($i=1; $i <=5; $i++) @if($i<=$criterias->lastPage())
                    <li class="page-item {{ ($i==$criterias->currentPage()) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $criterias->url($i) }}">{{ $i }}</a>
                    </li>
                    @endif
                    @endfor
                    @elseif(($criterias->currentPage() >= $criterias->lastPage()-1))
                    @for ($i = $criterias->lastPage()-4; $i <=$criterias->lastPage(); $i++)
                        @if($i>=1)
                        <li class="page-item {{ ($i==$criterias->currentPage()) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $criterias->url($i) }}">{{ $i }}</a>
                        </li>
                        @endif
                        @endfor
                        @else
                        @for ($i = -2; $i <=2; $i++) <li class="page-item {{ ($i==0) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $criterias->url($criterias->currentPage()+$i) }}">{{ $criterias->currentPage()+$i }}</a>
                            </li>
                            @endfor
                            @endif

                            @if($criterias->currentPage() != $criterias->lastPage())

                            <li class="page-item">
                                <a class="page-link" href="{{ $criterias->url($criterias->lastPage()) }}">»</a>
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
                    Hottest
                </span>
            </label>

            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="">
                <span>
                    Newest
                </span>
            </label>

            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="">
                <span>
                    Oldest
                </span>
            </label>

        </div>
    </div>




</div>


@endsection