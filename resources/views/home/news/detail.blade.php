@extends('layouts.h5')

@section('thirdcss')

@endsection
@section('thirdjs')

@endsection

@section('content')

    <div class="container">

        {!! $news->content !!}
    </div>

@endsection
