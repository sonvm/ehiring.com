@extends('layouts.default')

@section('title', 'Apply')

@section('page-header', 'Apply Form')

@section('content')

<?php

echo auth()->user()->name;
echo '<br>';

echo auth()->user()->email;
echo '<br>';

foreach ($roles as $role) {
    echo $role->name;
    echo '<br>';
}
?>



@endsection