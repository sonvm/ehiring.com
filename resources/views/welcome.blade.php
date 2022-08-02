@extends('layouts.default')

@section('title', 'Home')

@section('sidebar')
    @parent

    <p>Phần phụ của sidebar.</p>
@endsection

@section('content')
    <p>Phần nội dung chính của trang ở đây.</p>


@endsection