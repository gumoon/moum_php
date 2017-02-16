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
				<a href="#one14-general" data-toggle="collapse">基本信息</a>
			</h4>
		</div>
			
			<ul class="list-group" id="one14-general">
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
	

	{!! $one14->detail !!}
</div>

@endsection
