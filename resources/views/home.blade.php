@extends('layouts.app')

@section('thirdjs')
<script type="text/javascript" src="{{ mix('js/home/home.index.js') }}"></script>
<script type="text/javascript">
	Pusher.logToConsole = true;

	Echo.channel('access-shop')
	    .listen('.moum\\Events\\AccessShopEvent', (e) => {
	        console.log(e.shop.tel);
    	});
</script>
@endsection

@section('content')

<div class="container">
    <div class="jumbotron">
        <h1>경모음<small> is coming soon!</small></h1>
        <p>경모음是针对来华韩国人市场推出的生活服务APP。</p>
    </div>
    <div id="app">
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
</div>
@endsection
