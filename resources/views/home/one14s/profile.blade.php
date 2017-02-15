@extends('layouts.h5')

@section('thirdcss')
<link rel="stylesheet" href="{{ mix('css/one14h5.css') }}">
@endsection
@section('thirdjs')
<script type="text/javascript" src="{{ mix('js/home/one14.profile.js') }}"></script>
@endsection

@section('content')

<div class="container">
	<div class="page-head">
		<div class="row">
			<div class="col-xs-12 list">
				<span class="glyphicon glyphicon-th icon" aria-hidden="true"></span>
				<span class="text-primary h4"> {{$one14->name}}</span>
			</div>
			<div class="col-xs-12 list">
				<span class="glyphicon glyphicon-map-marker icon" aria-hidden="true"></span>
				<span class="text-primary h4"> {{$one14->addr}}</span>
			</div>
		</div>
	</div>
	

	{!! $one14->detail !!}
</div>

@endsection
