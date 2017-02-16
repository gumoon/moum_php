@extends('layouts.h5')

@section('thirdcss')

@endsection
@section('thirdjs')

@endsection

@section('content')

<div class="container">
	<div class="panel panel-success" style="margin-top: 5px;">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a href="#rent-general" data-toggle="collapse" aria-expanded="true">基本信息</a>
			</h4>
		</div>
		<div class="panel-collapse collapse in" id="rent-general">	
			<ul class="list-group">
				<li class="list-group-item">
					<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
					<span class="text-muted h5"> {{$rent->title}}</span>
				</li>
				<li class="list-group-item">
					<span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
					<span class="text-muted h5"> {{$rent->house_type}}</span>
				</li>
				<li class="list-group-item">
					<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
				<span class="text-muted h5"> {{$rent->addr}}</span>
				</li>
				<li class="list-group-item">
					<span class="glyphicon glyphicon-yen" aria-hidden="true"></span>
				<span class="text-muted h5"> {{$rent->price}} 元/月</span>
				</li>
			</ul>
		</div>
	</div>
	

	{!! $rent->detail !!}
</div>

@endsection
