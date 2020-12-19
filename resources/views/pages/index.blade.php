@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron text-center">
        <h1>Verge Systems</h1>
        <br/>
        @if(Auth::guest())
        <p><a href="/login" class="btn btn-primary btn-lg">Login</a> <a href="/register" class="btn btn-success btn-lg">Register</a></p>
        @endif
    </div>
    @if(count($posts))
      <div class="row">
        @foreach($posts as $post)
        <div class="col-lg-33">
          <h2>{{$post->title}}</h2>
          <p class="text-danger">{!!str_limit($post->body, $limit = 400, $end = '...')!!}
          <a href="/news/{{$post->id}}">...Read More</a></p>
        </div>
        @endforeach
      </div>
    @endif
</div>
@endsection