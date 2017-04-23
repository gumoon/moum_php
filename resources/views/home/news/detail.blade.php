@extends('layouts.h5')

@section('thirdcss')

@endsection
@section('thirdjs')

@endsection

@section('content')

    <div class="container">
        <h3>{{$news->title}}</h3>
        <div class="small"><span class="">{{substr($news->public_at, 0, 10)}}</span>&nbsp;&nbsp;&nbsp;&nbsp; {{\moum\Models\News::$sources[$news->source]['name']}}</div>
        <br />
        {!! $news->content !!}
    </div>

@endsection
