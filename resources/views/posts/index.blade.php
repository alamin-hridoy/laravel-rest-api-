@extends('layouts.app')

@section('content')
<h3>Organization News<a href="#" class="pull-right"><img id="help-icon" src="{{ asset('storage/icon/Help.png') }}"></a></h3>
<div class="well">
    @if(!Auth()->guest() && (Auth()->user()->admin))
    <a href="/news/create" class="btn btn-primary btn-xl">Add News</a>
    <br/><br/>
    @endif
    @if (count($posts))
    <div class="table-responsive">
        <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>News</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($posts as $post)
            <tr>
                <div class="row post">
                    <td>
                        <div class="col-md-20 col-md-offset-3">
                            <img src="/storage/thumbnails/{{$post->thumbnail}}" class="thumbnail">
                        </div>
                    </td>
                    <td>
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
                            {!!str_limit($post->body, $limit = 400, $end = '...')!!}<a href="/news/{{$post->id}}">...Read More</a>
                        </div>
                    </td>
                </div>
            </tr>
        @endforeach
        </tbody>
        </table>
    </div>
    @else
        <h3>No news to show</h3>
    @endif
</div>
@endsection