@extends('layouts.default')

@section('title', 'Suggestion')

@section('page-header', 'Suggestion')
@section('content')

<br>

<table class="table table-hover">
    <thead>
        <tr class="table-dark">
            <th scope="col">Canidate</th>
            @foreach($criterias as $criteria)
            <th scope="col">{{$criteria['name']}}</th>
            @endforeach
            <th scope="col">S*</th>
            <th scope="col">S-</th>
            <th scope="col">C</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $i = 0;
        ?>

        @foreach ($cvs as $cv)

        @if ($i==$c)
        <tr class="table-active">
            @else

        <tr>
            @endif


            <th scope="row">{{$cv->name}}</th>

            @foreach ($criterias as $criteria)
            <?php $t_name = $criteria['name']; ?>

            <td>{{$cv->$t_name}}</td>
            @endforeach
            <td>{{$cv->dtb}}</td>
            <td>{{$cv->dtw}}</td>
            <td>{{$cv->c}}</td>

            <?php $i++; ?>

        </tr>

        @endforeach

        <tr>
            <td><br /></td>
        </tr>


        <tr class="table-success">
            <th scope="row">A*</th>
            @foreach($best as $b)

            <td>{{$b}}</td>
            @endforeach
            <td class="primary"></td>
            <td class="primary"></td>
            <td class="primary"></td>
        </tr>

        <tr class="table-danger">
            <th scope="row">A-</th>
            @foreach($worst as $w)

            <td>{{$w}}</td>
            @endforeach
            <td class="primary"></td>
            <td class="primary"></td>
            <td class="primary"></td>
        </tr>
    </tbody>
</table>





@endsection