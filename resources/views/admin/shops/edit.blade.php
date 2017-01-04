@extends('admin.layouts.houtai')

@section('headcss')
<!-- Morris Charts CSS -->
<link href="{{ asset('admin/vendor/morrisjs/morris.css') }}" rel="stylesheet">
@endsection

@section('thirdjs')
<!-- Morris Charts JavaScript -->
<script src="{{ asset('admin/vendor/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('admin/vendor/morrisjs/morris.min.js') }}"></script>
<script src="{{ asset('admin/data/morris-data.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/data/jquery.form.js') }}"></script>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=ba07f815eee649971fedc65ba266300e"></script>
@endsection

@section('customjs')
<script type="text/javascript">
var changeCatUrl = "{{ url('houtai/shops/get_types') }}";
var url = "{{ url('houtai/ajax/shops/store') }}";
var map = new AMap.Map('map',{
    zoom: 14,
    center: [{{$shop->lng}},{{$shop->lat}}],
    scrollWheel: false
});
//分类改变调用函数
function changeCat(){
	var cat_id = $("#cat_id option:selected").val();
	var token = $("input[name='_token']").val();
	var postData = {cat_id: cat_id, _token: token};
	console.log(postData);
	$.post(changeCatUrl, postData, function(data){
		if(data.err_no){
			alert(data.msg);
		}else{
			console.log(data);
			for(id in data.data){
				var str = '<option value="'+id+'">'+data.data[id]+'</option>';
				$("#type_id").append(str);
			}
		}
	});
}

function processJson0(data){
	$("#image_url01").attr("src", data.data.url);
	$("#image_url01").attr("alt", data.data.filename);
}
function clickButton0()
{
	$("#image_url01").attr("src", "");
	$("#image_url01").attr("alt", "");
}

function processJson1(data){
	$("#image_url11").attr("src", data.data.url);
	$("#image_url11").attr("alt", data.data.filename);
}
function clickButton1()
{
	$("#image_url11").attr("src", "");
	$("#image_url11").attr("alt", "");
}

function processJson2(data){
	$("#image_url21").attr("src", data.data.url);
	$("#image_url21").attr("alt", data.data.filename);
}
function clickButton2()
{
	$("#image_url21").attr("src", "");
	$("#image_url21").attr("alt", "");
}

function processJson3(data){
	$("#image_url31").attr("src", data.data.url);
	$("#image_url31").attr("alt", data.data.filename);
}
function clickButton3()
{
	$("#image_url31").attr("src", "");
	$("#image_url31").attr("alt", "");
}

function processJson4(data){
	$("#image_url41").attr("src", data.data.url);
	$("#image_url41").attr("alt", data.data.filename);
}
function clickButton4()
{
	$("#image_url41").attr("src", "");
	$("#image_url41").attr("alt", "");
}

function processError(){
	alert('上传出错了');
}
//选择文件后，自动上传图片
function changeFile0(){
	var options = {
		url: "{{ url('/tools/upload_image') }}",
		type: 'post',
		dataType: 'json',
		success: processJson0,
		error: processError
	};
	$("#uploadImage0").ajaxSubmit(options);
	return false;
}

function changeFile4(){
	var options = {
		url: "{{ url('/tools/upload_image') }}",
		type: 'post',
		dataType: 'json',
		success: processJson4,
		error: processError
	};
	$("#uploadImage4").ajaxSubmit(options);
	return false;
}

function changeFile1(){
	var options = {
		url: "{{ url('/tools/upload_image') }}",
		type: 'post',
		dataType: 'json',
		success: processJson1,
		error: processError
	};
	$("#uploadImage1").ajaxSubmit(options);
	return false;
}

function changeFile2(){
	var options = {
		url: "{{ url('/tools/upload_image') }}",
		type: 'post',
		dataType: 'json',
		success: processJson2,
		error: processError
	};
	$("#uploadImage2").ajaxSubmit(options);
	return false;
}

function changeFile3(){
	var options = {
		url: "{{ url('/tools/upload_image') }}",
		type: 'post',
		dataType: 'json',
		success: processJson3,
		error: processError
	};
	$("#uploadImage3").ajaxSubmit(options);
	return false;
}

function dragendMarker(event)
{
	var lat = event.lnglat.getLat();
	var lng = event.lnglat.getLng();

	AMap.service('AMap.Geocoder',function(){//回调函数
	    //实例化Geocoder
	    geocoder = new AMap.Geocoder({
	        city: "010"//城市，默认：“全国”
	    });
	    //TODO: 使用geocoder 对象完成相关功能
	    //逆地理编码
		var lnglatXY=[lng, lat];//地图上所标点的坐标
		geocoder.getAddress(lnglatXY, function(status, result) {
		    if (status === 'complete' && result.info === 'OK') {
		       //获得了有效的地址信息:
		       //即，result.regeocode.formattedAddress
		       map.panTo(lnglatXY);
		       $("#addr").val(result.regeocode.formattedAddress);
		    }else{
		       //获取地址失败
		    }
		});
	})
 
	$("#lat").val(lat);
	$("#lng").val(lng);
}

function search(){
	var addr = $("#addr").val();
	AMap.service('AMap.Geocoder',function(){//回调函数
	    //实例化Geocoder
	    geocoder = new AMap.Geocoder({
	        city: "010"//城市，默认：“全国”
	    });
	    //TODO: 使用geocoder 对象完成相关功能
	    //地理编码
		geocoder.getLocation( addr, function(status, result) {
		    if (status === 'complete' && result.info === 'OK') {
		        //TODO:获得了有效经纬度，可以做一些展示工作
		        //比如在获得的经纬度上打上一个Marker
		        var lat = result.geocodes[0].location.getLat();
		        var lng = result.geocodes[0].location.getLng();
		        var position = [lng, lat];
		        map.panTo(position);
		        map.clearMap();
		        var marker = new AMap.Marker({
		        	position: position,
		        	draggable: true
		        });
		        marker.setMap(map);
		        marker.on('dragend', dragendMarker);

		        $("#lat").val(lat);
		        $("#lng").val(lng);
		    }else{
		        //获取经纬度失败
		    }
		});
	});
}

function submitUpdateShop()
{
	var name = $("#name").val();
	var is_vip = $("input:checked").val();
	var cat_id = $("#cat_id :selected").val();
	var type_id = $("#type_id :selected").val();
	var tel = $("#tel").val();
	var bosstel = $("#bosstel").val();
	var open_time = $("#open_time").val();
	var addr = $("#addr").val();
	var lng = $("#lng").val();
	var lat = $("#lat").val();
	var intro = $("#intro").val();
	var image_url01 = $("#image_url01").attr("alt");
	var image_url11 = $("#image_url11").attr("alt");
	var image_url21 = $("#image_url21").attr("alt");
	var image_url31 = $("#image_url31").attr("alt");
	var image_url41 = $("#image_url41").attr("alt");

	var postData = {name: name, is_vip: is_vip, cat_id: cat_id, type_id: type_id, tel: tel, bosstel: bosstel, open_time: open_time, addr: addr, lng: lng, lat: lat, intro: intro, image_url01: image_url01, image_url11: image_url11, image_url21: image_url21, image_url31: image_url31, image_url41: image_url41};
	console.log(postData);
	var options = {
		url: "{{ url('/houtai/shops/') }}"+'/'+{{$shop->id}},
		type: 'put',
		dataType: 'json',
		data: postData,
		success: function(data){
			alert(data.msg);
			window.location.href = "{{ url('/houtai/shops') }}";
		},
		error: function(){
			alert('出错了')
		}
	};
	$("#updateShop").ajaxSubmit(options);
	return false;
}

$(document).ready(function(){

	$("#cat_id").on("change", changeCat);
	$("#image_url0").on("change", changeFile0);
	$("#image_url1").on("change", changeFile1);
	$("#image_url2").on("change", changeFile2);
	$("#image_url3").on("change", changeFile3);
	$("#image_url4").on("change", changeFile4);

	AMap.plugin(['AMap.ToolBar','AMap.Scale','AMap.OverView'],
    function(){
        map.addControl(new AMap.ToolBar());
 
        map.addControl(new AMap.Scale());
 
        map.addControl(new AMap.OverView({isOpen:true}));
	});

    var marker = new AMap.Marker({
    	position: [{{$shop->lng}}, {{$shop->lat}}],
    	draggable: true
    });
    marker.setMap(map);
    marker.on('dragend', dragendMarker);

	$("#updateShop").submit(submitUpdateShop);
});
</script>
@endsection

@section('content')
<div id="wrapper">

    @include('admin.layouts.navigation')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">编辑商户</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
        			<div class="panel-heading">
        				请输入相关信息
        			</div>
        			<div class="panel-body">
        				<div class="row">
        					<div class="col-lg-6">
    							<div class="form-group" id="namediv">
    								<label>商户名称</label>
    								<input type="text" id="name" name="name" class="form-control" placeholder="" value="{{ $shop->name }}">

                                    <span class="help-block">
                                    </span>
    							</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
                                    <label>是否VIP商户</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="is_vip" value="0" @if( $shop->is_vip == 0)checked @endif>否
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="is_vip" value="1" @if( $shop->is_vip == 1)checked @endif>是
                                    </label>
                                </div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
                                <div class="form-group" id="catdiv">
									<label>商户分类</label>
									<select class="form-control" id="cat_id" name="cat_id">
										<option value="-1">请选择分类</option>
										@foreach ($shopCats as $key => $shopCat)
										<option value="{{$key}}" @if( $shop->cat_id == $key) selected @endif >{{$shopCat}}</option>
										@endforeach
									</select>
									<span class="help-block"></span>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group" id="typediv">
									<label>商户子分类</label>
									<select class="form-control" id="type_id" name="type_id">
										<option value="-1">请选择子分类</option>
										@foreach ($shopTypes[$shop->cat_id] as $k => $shopType)
										<option value="{{$k}}" @if( $shop->type_id == $k) selected @endif >{{$shopType}}</option>
										@endforeach
									</select>
									<span class="help-block"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group" id="teldiv">
    								<label>联系电话</label>
    								<input type="tel" id="tel" name="tel" class="form-control" placeholder="" value="{{ $shop->tel }}">
                                    <span class="help-block">
                                    </span>
    							</div>
    						</div>
    						<div class="col-lg-6">
    							<div class="form-group" id="bossteldiv">
    								<label>老板手机号</label>
    								<input type="tel" id="bosstel" name="bosstel" class="form-control" placeholder="" value="{{ $shop->boss_tel }}">
                                    <span class="help-block">
                                    </span>
    							</div>
    						</div>
    					</div>

        				<div class="row">
        					<div class="col-lg-6">
    							<div class="form-group">
    								<label>营业时间</label>
    								<input type="text" id="open_time" name="open_time" class="form-control" placeholder="" value="{{ $shop->open_time }}">
                                    <span class="help-block">
                                    </span>
    							</div>
    						</div>
    						<div class="col-lg-6">
    							<div class="form-group">
    								<label>地址</label>
    								<div class="input-group">
								      <input type="text" id="addr" name="addr" class="form-control" placeholder="" value="{{ $shop->addr }}">
								      <span class="input-group-btn">
								        <button class="btn btn-default" type="button" onclick="search();">搜索</button>
								      </span>
								    </div><!-- /input-group -->
                                    <span class="help-block">
                                    </span>
    							</div>
    						</div>
    					</div>

    					<div class="row">
    						<div class="col-lg-6">
        						<div id="map" style="width: 100%; height: 300px;"></div>
        					</div>
    						<div class="col-lg-6">
    							<div class="form-group" id="introdiv">
									<label>老板一句话简介：</label>
									<textarea class="form-control" rows="8" id="intro" name="intro" placeholder="">{{ $shop->intro }}</textarea>

									<span class="help-block">
                                    </span>
								</div>
        					</div>
        				</div>

        				<div class="row">
    						<div class="col-lg-6">
    							<div class="form-group" id="introdiv">
									<label>经度</label>
									<input type="text" id="lng" name="lng" class="form-control" placeholder="" value="{{ $shop->lng }}">

									<span class="help-block">
                                    </span>
								</div>
        					</div>
        					<div class="col-lg-6">
        						<div class="form-group" id="introdiv">
									<label>纬度</label>
									<input type="text" id="lat" name="lat" class="form-control" placeholder="" value="{{ $shop->lat }}">

									<span class="help-block">
                                    </span>
								</div>
        					</div>
        				</div>

        				<div class="row">
							<div class="col-lg-6">
								<form role="form" id="uploadImage0" enctype="multipart/form-data">
        							<div class="form-group">
                                            <label>商户头图</label>
                                            <input type="file" id="image_url0" name="image_url">
                                            {{ csrf_field() }}
                                 	</div>
								</form>
							</div>
							<div class="col-lg-6">
								<img src="{{$shop->image_url_src}}" alt="{{$shop->image_url}}" id="image_url01" style="width: 100px; height: 100px" >
								<button class="btn btn-default" onclick="clickButton0()">删除</button>
							</div>
						</div>	
									
						<div class="row">
							<div class="col-lg-6">
								<form role="form" id="uploadImage1" enctype="multipart/form-data">
        							<div class="form-group">
                                            <label>菜单图1</label>
                                            <input type="file" id="image_url1" name="image_url">
                                            {{ csrf_field() }}
                                 	</div>
								</form>
							</div>
							<div class="col-lg-6">
								<img src="{{$shop->image_url11_src}}" alt="{{$menu_image_urls['image_url11']}}" id="image_url11" style="width: 100px; height: 100px">
								<button class="btn btn-default" onclick="clickButton1()">删除</button>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<form role="form" id="uploadImage2" enctype="multipart/form-data">
        							<div class="form-group">
                                            <label>菜单图2</label>
                                            <input type="file" id="image_url2" name="image_url">
                                            {{ csrf_field() }}
                                 	</div>
								</form>							
							</div>
							<div class="col-lg-6">
								<img src="{{$shop->image_url21_src}}" alt="{{$menu_image_urls['image_url21']}}" id="image_url21" style="width: 100px; height: 100px">
								<button class="btn btn-default" onclick="clickButton2()">删除</button>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<form role="form" id="uploadImage3" enctype="multipart/form-data">
        							<div class="form-group">
                                            <label>菜单图3</label>
                                            <input type="file" id="image_url3" name="image_url">
                                            {{ csrf_field() }}
                                 	</div>
								</form>
							</div>
							<div class="col-lg-6">
								<img src="{{$shop->image_url31_src}}" alt="{{$menu_image_urls['image_url31']}}" id="image_url31" style="width: 100px; height: 100px">
								<button class="btn btn-default" onclick="clickButton3()">删除</button>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<form role="form" id="uploadImage4" enctype="multipart/form-data">
        							<div class="form-group">
                                            <label>菜单图4</label>
                                            <input type="file" id="image_url4" name="image_url">
                                            {{ csrf_field() }}
                                 	</div>
								</form>
							</div>
							<div class="col-lg-6">
								<img src="{{$shop->image_url41_src}}" alt="{{$menu_image_urls['image_url41']}}" id="image_url41" style="width: 100px; height: 100px">
								<button class="btn btn-default" onclick="clickButton4()">删除</button>
							</div>
						</div>
									
						<form id="updateShop">		
						{{ csrf_field() }}
						<button type="submit" class="btn btn-success">更新</button>
						</form>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
@endsection