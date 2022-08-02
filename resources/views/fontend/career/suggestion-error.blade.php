@extends('layouts.default')

@section('title', 'Cannot get suggestion')

@section('page-header', 'Cannot get suggestion')

@section('content')

<?php 
$message = session('message');
$existed = session('existed');
?>
@include('layouts.message')

@endsection