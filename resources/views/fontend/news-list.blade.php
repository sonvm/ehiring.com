@extends('layouts.default')

@section('title', 'Danh sách tin tức')

@section('content')
    @foreach($news_list as $news)
      <div class="col-md-3"> 
      @if($loop->first)
        @include('layouts.news-item', ['title' => $news['title'], 'content' => $news['content'], 'post_date' => $news['post_date'], 'class' => 'success'])
      @else
        @include('layouts.news-item', ['title' => $news['title'], 'content' => $news['content'], 'post_date' => $news['post_date'], 'class' => 'primary'])
      @endif
      </div>
    @endforeach
@endsection




