@extends('layouts.h5')

@section('thirdcss')

@endsection
@section('thirdjs')

@endsection

@section('content')

    <div class="container">
        <h3>{{$news->title}}</h3>
        <span>{{substr($news->public_at, 0, 10)}}&span;&span;&span;&span;{{\moum\Models\News::$sources[$news->source]['name']}}</span>
        {!! $news->content !!}
    </div>

@endsection
