@extends('layouts.app')

@section('content')
<h3>{{$post->title}}<a href="#" class="pull-right"><img id="help-icon" src="{{ asset('storage/icon/Help.png') }}"></a></h3>
<div class="well">
    <div class="row post">
        <div class="col-md-20 col-md-offset-3">
            <img src="/storage/thumbnails/{{$post->thumbnail}}" class="thumbnail">
        </div>
        <div class="col-md-68 col-md-offset-3">
            @if(!Auth()->guest() && (Auth()->user()->id == $post->user_id))
            {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('DELETE', ['class' => 'btn btn-danger btn-md'])}}
            {!!Form::close()!!}
            <a href="/news/{{$post->id}}/edit" class="pull-right"><img src="{{ asset('storage/icon/Edit.png') }}" class="icon"></a>
            @endif
            <h3 class="post-title">{{$post->title}}</h3>
            <p><small>By {{$post->user->name}} {{$post->updated_at->diffForHumans()}}</small></p>
            {!!$post->body!!}
        </div>
    </div>
</div>
@endsection