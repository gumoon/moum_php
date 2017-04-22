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
@endsection

@section('customjs')
<script type="text/javascript">
function processJson(data){
	$("#image_url1").attr("src", data.data.url);
	$("#image_url1").attr("alt", data.data.filename);
}
function clickButton()
{
	$("#image_url1").attr("src", "");
	$("#image_url1").attr("alt", "");
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

function submitUpdateSpread()
{
	var title = $("#title").val();
	var flag = $("#flag :selected").val();
	var extra = $("#extra").val();
	var image_url1 = $("#image_url1").attr("alt");
	var order = $("#order").val();

	var postData = {title: title, flag: flag, extra: extra, image_url: image_url1, order: order};
	console.log(postData);
	var options = {
		url: "{{ url('/houtai/magazinePages') }}"+'/'+{{$spread->id}},
		type: 'put',
		dataType: 'json',
		data: postData,
		success: function(data){
			alert(data.msg);
			window.location.href = "{{ url('/houtai/magazinePages') }}";
		},
		error: function(){
			alert('出错了')
		}
	};
	$("#updateSpread").ajaxSubmit(options);
	return false;
}

$(document).ready(function(){
	$("#image_url").on("change", changeFile);
	$("#updateSpread").submit(submitUpdateSpread);
});
</script>
@endsection

@section('content')
<div id="wrapper">

    @include('admin.layouts.navigation')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">更新信息</h1>
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
    							<div class="form-group" id="titlediv">
    								<label>描述</label>
    								<input type="text" id="title" name="title" class="form-control" placeholder="" value="{{$spread->title}}">

                                    <span class="help-block">
                                    </span>
    							</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
    								<label>请选择类型</label>
    								<select class="form-control" id="flag" name="flag">
										<option value="-1">请选择类型</option>
										<option value="0" @if($spread->flag == 0) selected @endif>外部网址</option>
										<option value="1" @if($spread->flag == 1) selected @endif>外卖商户</option>
										<option value="2" @if($spread->flag == 2) selected @endif>114企业</option>
									</select>
                                    <span class="help-block">
                                    </span>
    							</div>
    						</div>
							<div class="col-lg-6">
								<div class="form-group">
    								<label>扩展信息（网址，或外卖商户ID，或114企业ID)</label>
    								<input type="text" id="extra" name="extra" class="form-control" placeholder="" value="{{$spread->extra}}">
                                    <span class="help-block">
                                    </span>
    							</div>
    						</div>
    					</div>

    			

        				<div class="row">
							<div class="col-lg-6">
								<form role="form" id="uploadImage" enctype="multipart/form-data">
        							<div class="form-group">
                                            <label>图片</label>
                                            <input type="file" id="image_url" name="image_url">
                                            {{ csrf_field() }}
                                 	</div>
								</form>
							</div>
							<div class="col-lg-6">
								<img src="{{$spread->image_url_src}}" alt="{{$spread->image_url}}" id="image_url1" style="width: 100px; height: 100px" >
								<button class="btn btn-default" onclick="clickButton()">删除</button>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
    								<label>排序（数字越大，排前面）</label>
    								<input type="number" id="order" name="order" class="form-control" placeholder="" value="{{$spread->order}}">
                                    <span class="help-block">
                                    </span>
    							</div>
							</div>
						</div>	

						<form id="updateSpread">		
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