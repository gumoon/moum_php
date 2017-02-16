@extends('layouts.app')

@section('thirdcss')
<link rel="stylesheet" href="{{ mix('css/home.index.css') }}">
@endsection

@section('thirdjs')
<script type="text/javascript" src="{{ mix('js/home/home.index.js') }}"></script>
@endsection

@section('content')

<div class="container">

	<!-- 轮播图 -->
	<div id="m-carousel" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		<ol class="carousel-indicators">
		    <li data-target="#m-carousel" data-slide-to="0" class="active"></li>
		    <li data-target="#m-carousel" data-slide-to="1"></li>
		    <li data-target="#m-carousel" data-slide-to="2"></li>
		</ol>

		  <!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
		    <div class="item active">
		        <img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1487269974690&di=b98d248efd74d238d98d529679cbfd1c&imgtype=0&src=http%3A%2F%2Fimg17.3lian.com%2Fd%2Ffile%2F201702%2F16%2F41ca4a12ad8279bfad1cc34072c33e0d.jpg" alt="1">
		        <div class="carousel-caption">
		          	<h3>First Slide label</h3>
		          	<p>第一张幻灯片</p>
		        </div>
		    </div>
		    <div class="item">
			    <img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1487269974691&di=56109004a50b368a4ea7d740dfd8b0e0&imgtype=0&src=http%3A%2F%2Fimg17.3lian.com%2Fd%2Ffile%2F201702%2F16%2F3623215932847da70948f84b3bab0acf.jpg" alt="2">
			    <div class="carousel-caption">
			        <h3>Second Slide label</h3>
			        <p>第二张幻灯片</p>
			    </div>
		    </div>
		    <div class="item">
			    <img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1487269974690&di=fc42b842b122cf66fbebf0077380eae1&imgtype=0&src=http%3A%2F%2Fpic1.win4000.com%2Fwallpaper%2F6%2F578855bbb2762.jpg" alt="3">
			    <div class="carousel-caption">
			        <h3>Third Slide label</h3>
			        <p>第三张幻灯片</p>
			    </div>
		    </div>
		</div>

		  <!-- Controls -->
		<a class="left carousel-control" href="#m-carousel" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#m-carousel" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		</a>
	</div>

    <div class="jumbotron">
        <h1>Moum<small> is coming soon!</small></h1>
        <p>Moum是针对来华韩国人市场推出的生活服务APP。</p>
    </div>
    
	@{{message}}
	<span v-bind:title="message">
		Hover your mouse over me for a few seconds to see my title!
	</span>
	<p v-if="seen">Now you see me</p>
	<ol>
<!--     		<li v-for="todo in todos" v-on:click="clickTodo">
			@{{ todo.text }}
		</li> -->
		<todo-item v-for="todo in todos" v-bind:todo="todo"></todo-item>
	</ol>
	<input type="text" name="" v-model="message">
</div>
@endsection
