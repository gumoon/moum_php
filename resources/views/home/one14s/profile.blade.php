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
				<a href="#one14-general" data-toggle="collapse" aria-expanded="true">基本信息</a>
			</h4>
		</div>
		<div class="panel-collapse collapse in" id="one14-general">
			<ul class="list-group">
				<li class="list-group-item">
					<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
					<span class="text-muted h5"> {{$one14->name}}</span>
				</li>
				<li class="list-group-item">
					<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
				<span class="text-muted h5"> {{$one14->addr}}</span>
				</li>
			</ul>
		</div>
	</div>
	

	{!! $one14->detail !!}
</div>

@endsection
