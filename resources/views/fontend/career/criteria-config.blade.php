@extends('layouts.default')

@section('title', 'Criteria Config')

@section('page-header', 'Criteria Config')
@section('content')

@include('layouts.message')

{!! Form::open(array('url' => '/careers/'.$id.'/criteria/update', 'class' => 'form-horizontal','method' => 'get')) !!}
<table class="table table-hover">
    <thead>
        <tr class="table-dark">
            <th scope="col">Checkbox</th>
            <th scope="col">Criteria</th>
            <th scope="col">Weight</th>
        </tr>
    </thead>
    <tbody>
        @foreach($criterias as $criteria)
        <tr>
            <?php
            $c_id = $criteria->id;
            $name = $criteria->name;
            $is_cost_criteria = ($criteria->is_cost_criteria);
            $weight = $criteria->weight;
            //echo 'weight: ' . $weight . '<br>';
            $checked = $criteria->checked;
            ?>
            <th>
                <?php
                $c_name = 'criteria_' . $c_id;
                $c_weight = 'criteria_w_' . $c_id;
                ?>
                @if($checked)
                <input class="form-check-input" type="checkbox" value="{{$c_id}}" name="{{$c_name}}" checked="">
                @else
                <input class="form-check-input" type="checkbox" value="{{$c_id}}" name="{{$c_name}}">
                @endif
            </th>
            <th>
                <label class="form-check-label" for="flexCheckDefault">
                    {{$name}}
                    @if($is_cost_criteria)
                    (cost)
                    @endif
                </label>
            </th>
            <th>
                {!! Form::number($c_weight, $weight, array('class' => 'form-control')) !!}
            </th>

        </tr>


        @endforeach
    </tbody>
</table>


<div class="d-flex justify-content-center">
    <button class="btn btn-primary" type="submit" id="button-addon2">Update</button>
</div>

{!! Form::close() !!}







</div>


@endsection