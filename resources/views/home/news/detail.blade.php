@extends('layouts.h5')

@section('thirdcss')

@endsection
@section('thirdjs')

@endsection

@section('content')

    <div class="container">
        <h3>{{$news->title}}</h3>
        <span>{{substr($news->public_at, 0, 10)}}     {{\moum\Models\News::$sources[$news->source]['name']}}</span>
        <br/>
        {!! $news->content !!}
    </div>

@endsection
