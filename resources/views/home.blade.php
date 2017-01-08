@extends('layouts.app')

@section('thirdjs')
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
</div>
@endsection
