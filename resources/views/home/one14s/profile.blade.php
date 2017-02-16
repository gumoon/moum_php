@extends('layouts.h5')

@section('thirdcss')
<link rel="stylesheet" href="{{ mix('css/one14h5.css') }}">
@endsection
@section('thirdjs')
<script type="text/javascript" src="{{ mix('js/home/one14.profile.js') }}"></script>
@endsection

@section('content')

<div class="container">
	<div class="panel panel-success">
		<div class="panel-heading">基本信息</div>
			
			<ul class="list-group">
				<li class="list-group-item">
					<span class="glyphicon glyphicon-th icon" aria-hidden="true"></span>
					<span class="text-primary h4"> {{$one14->name}}</span>
				</li>
				<li class="list-group-item">
					<span class="glyphicon glyphicon-map-marker icon" aria-hidden="true"></span>
				<span class="text-primary h4"> {{$one14->addr}}</span>
				</li>
			</ul>
	</div>
	

	{!! $one14->detail !!}
</div>

@endsection
