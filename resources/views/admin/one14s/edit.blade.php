@extends('admin.layouts.houtai')

@section('headcss')
<!-- Morris Charts CSS -->
<link href="{{ asset('admin/vendor/morrisjs/morris.css') }}" rel="stylesheet">
<script type="text/javascript" src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
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
var changeCatUrl = "{{ url('houtai/one14s/get_types') }}";
var map = new AMap.Map('map',{
    zoom: 14,
    center: [116.337844,39.99293],
    scrollWheel: false
});
var marker = new AMap.Marker({
	position: [116.337844, 39.99293],
	draggable: true
});
marker.setMap(map);
marker.on('dragend', dragendMarker);

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
				var str = '<option value="'+data.data[id].id+'">'+data.data[id].name+'</option>';
				$("#type_id").append(str);
			}
		}
	});
}

function processJson(data){
	$("#image_url01").attr("src", data.data.url);
	$("#image_url01").attr("alt", data.data.filename);
}
function clickButton()
{
	$("#image_url01").attr("src", "");
	$("#image_url01").attr("alt", "");
}

function processError(){
	alert('上传出错了');
}
//选择文件后，自动上传图片
function changeFile(){
	var options = {
		url: "{{ url('/tools/upload_image') }}",
		type: 'post',
		dataType: 'json',
		success: processJson,
		error: processError
	};
	$("#uploadImage").ajaxSubmit(options);
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
	});

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

function submitUpdateOne14()
{
	var name = $("#name").val();
	var is_vip = $("input:checked").val();
	var cat_id = $("#cat_id :selected").val();
	var type_id = $("#type_id :selected").val();
	var tel = $("#tel").val();
	var addr = $("#addr").val();
	var lng = $("#lng").val();
	var lat = $("#lat").val();
	var tags = $("#tags").val();
	var detail = CKEDITOR.instances.detail.getData();
	var image_url = $("#image_url01").attr("alt");

	var postData = {name: name, is_vip: is_vip, cat_id: cat_id, type_id: type_id, tel: tel, addr: addr, lng: lng, lat: lat, tags: tags, image_url: image_url, detail: detail};
	console.log(postData);
	
	var options = {
		url: "{{ url('/houtai/one14s') }}"+'/'+{{$one14->id}},
		type: 'put',
		dataType: 'json',
		data: postData,
		success: function(data){
			alert(data.msg);
			window.location.href = "{{ url('/houtai/one14s') }}";
		},
		error: function(){
			alert('出错了')
		}
	};
	$("#updateOne14").ajaxSubmit(options);
	return false;
}

$(document).ready(function(){

	$("#cat_id").on("change", changeCat);
	$("#image_url").on("change", changeFile);

	AMap.plugin(['AMap.ToolBar','AMap.Scale','AMap.OverView'],
    function(){
        map.addControl(new AMap.ToolBar());
 
        map.addControl(new AMap.Scale());
 
        map.addControl(new AMap.OverView({isOpen:true}));
	});
	AMap.service('AMap.Geocoder',function(){//回调函数
	    //实例化Geocoder
	    geocoder = new AMap.Geocoder({
	        city: "010"//城市，默认：“全国”
	    });
	});

	$("#updateOne14").submit(submitUpdateOne14);
});
</script>
@endsection

@section('content')
<div id="wrapper">

    @include('admin.layouts.navigation')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">添加114企业信息</h1>
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
    								<label>名称</label>
    								<input type="text" id="name" name="name" class="form-control" placeholder="" value="{{$one14->name}}">

                                    <span class="help-block">
                                    </span>
    							</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
                                    <label>是否VIP</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="is_vip" value="0" @if( $one14->is_vip == 0)checked @endif>否
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="is_vip" value="1" @if( $one14->is_vip == 1)checked @endif>是
                                    </label>
                                </div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
                                <div class="form-group" id="catdiv">
									<label>分类</label>
									<select class="form-control" id="cat_id" name="cat_id">
										<option value="-1">请选择分类</option>
										@foreach($one14Categories AS $cat)
										<option value="{{$cat['id']}}" @if( $one14->cat_id == $cat['id']) selected @endif>{{$cat['name']}}</option>
										@endforeach
									</select>
									<span class="help-block"></span>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group" id="typediv">
									<label>子分类</label>
									<select class="form-control" id="type_id" name="type_id">
										<option value="-1">请选择子分类</option>
										@foreach($one14Categories[$one14->cat_id]['types'] AS $type)
										<option value="{{$type['id']}}" @if($type['id'] == $one14->type_id) selected @endif>{{ $type['name'] }}</option>
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
    								<input type="tel" id="tel" name="tel" class="form-control" placeholder="" value="{{$one14->tel}}">
                                    <span class="help-block">
                                    </span>
    							</div>
    						</div>
    						<div class="col-lg-6">
    							<div class="form-group">
    								<label>地址</label>
    								<div class="input-group">
								      <input type="text" id="addr" name="addr" class="form-control" placeholder="" value="{{$one14->addr}}">
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
    							<div class="form-group">
    								<label>标签列表，用半角分号分隔</label>
    								<input type="text" name="tags" id="tags" class="form-control" placeholder="" value="{{$one14->tags}}">

    								<span class="help-block">
    									
    								</span>
    							</div>
    						</div>
        				</div>

        				<div class="row">
    						<div class="col-lg-6">
    							<div class="form-group" id="introdiv">
									<label>经度</label>
									<input type="text" id="lng" name="lng" class="form-control" placeholder="" value="{{$one14->lng}}">

									<span class="help-block">
                                    </span>
								</div>
        					</div>
        					<div class="col-lg-6">
        						<div class="form-group" id="introdiv">
									<label>纬度</label>
									<input type="text" id="lat" name="lat" class="form-control" placeholder="" value="{{$one14->lat}}">

									<span class="help-block">
                                    </span>
								</div>
        					</div>
        				</div>

        				<div class="row">
							<div class="col-lg-6">
								<form role="form" id="uploadImage" enctype="multipart/form-data">
        							<div class="form-group">
                                            <label>商户头图</label>
                                            <input type="file" id="image_url" name="image_url">
                                            {{ csrf_field() }}
                                 	</div>
								</form>
							</div>
							<div class="col-lg-6">
								<img src="{{$one14->image_url_src}}" alt="{{$one14->image_url}}" id="image_url01" style="width: 100px; height: 100px" >
								<button class="btn btn-default" onclick="clickButton()">删除</button>
							</div>
						</div>

						<div class="row">
							<div class="form-group">
									<label>详情(“样式类名称”
项请填写：img-thumbnail；并且“行内样式
”项为空)</label>
									<textarea name="detail" id="detail" rows="10" cols="80">{{$one14->detail}}</textarea>
									<script>
						                // Replace the <textarea id="editor1"> with a CKEditor
						                // instance, using default configuration.
						                CKEDITOR.replace('detail');
						            </script>
									<span class="help-block">
                                    </span>
							</div>
						</div>
											
						<form id="updateOne14">		
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