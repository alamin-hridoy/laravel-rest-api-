@extends('layouts.app')

@section('content')
<h3>Edit News</h3>
<div class="well">
    <a href="/dashboard" class="pull-right"><img src="{{ asset('storage/icon/Back.ico') }}" class="icon"></a>
    <h3 class="page-header">Edit News</h3>
    {!!Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'files' => true, 'data-parsley-validate' => ''])!!}
        <div class="form-group">
            {{Form::label('title', 'News Title')}}
            {{Form::text('title', $post->title, ['class' => 'form-control', 'data-parsley-required' => '', 'data-parsley-length' => '[4, 100]'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'News Details')}}
            {{Form::textarea('body', $post->body, ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
        </div>
        <div class="form-group">
            {{Form::label('thumbnail', 'New Image')}}
            {{Form::file('thumbnail')}}
        </div>
            {{Form::hidden('_method', 'PUT')}}
            {{Form::submit('Edit News', ['class' => 'btn btn-primary btn-xl center-block'])}}
    {!!Form::close()!!}
</div>
@endsection