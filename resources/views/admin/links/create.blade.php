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

function submitCreateLink()
{
	var name = $("#name").val();
	var nation_id = $("#nation_id :selected").val();
	var weburl = $("#url").val();
	var icon = $("#image_url1").attr("alt");

	var postData = {name: name, nation_id: nation_id, url: weburl, icon: icon};
	
	var options = {
		url: "{{ url('/houtai/links') }}",
		type: 'post',
		dataType: 'json',
		data: postData,
		success: function(data){
			console.log(data);
			alert(data.msg);
			window.location.href = "{{ url('/houtai/links') }}";
		},
		error: function(){
			alert('出错了')
		}
	};
	$("#createLink").ajaxSubmit(options);
	return false;
}

$(document).ready(function(){
	$("#image_url").on("change", changeFile);
	$("#createLink").submit(submitCreateLink);
});
</script>
@endsection

@section('content')
<div id="wrapper">

    @include('admin.layouts.navigation')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">添加网址</h1>
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
        				<div class="row col-lg-12">
	                        <div class="form-group" id="nationdiv">
								<label>国家</label>
								<select class="form-control" id="nation_id" name="nation_id">
									<option value="-1">请选择国家</option>
									<option value="0">中国</option>
									<option value="1">韩国</option>
								</select>
								<span class="help-block"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group" id="namediv">
									<label>网址名称</label>
									<input type="text" id="name" name="name" class="form-control" placeholder="">

		                            <span class="help-block">
		                            </span>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group" id="namediv">
									<label>网址URL</label>
									<input type="text" id="url" name="url" class="form-control" placeholder="">

		                            <span class="help-block">
		                            </span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<form role="form" id="uploadImage" enctype="multipart/form-data">
        							<div class="form-group">
                                            <label>图标</label>
                                            <input type="file" id="image_url" name="image_url">
                                            {{ csrf_field() }}
                                 	</div>
								</form>
							</div>
							<div class="col-lg-6">
								<img src="" id="image_url1" style="width: 100px; height: 100px">
								<button class="btn btn-default" onclick="clickButton()">删除</button>
							</div>
						</div>

						<form id="createLink">		
						{{ csrf_field() }}
						<button type="submit" class="btn btn-success">添加</button>
						</form>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
@endsection