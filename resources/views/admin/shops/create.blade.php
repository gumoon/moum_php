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
@endsection

@section('customjs')
<script type="text/javascript">
var changeUrl = "{{ url('houtai/ajax/shops/get_types') }}";
var url = "{{ url('houtai/ajax/shops/store') }}";
//分类改变调用函数
function changeCat(){
	var cat_id = $("#cat_id option:selected").val();
	var token = $("input[name='_token']").val();
	var postData = {cat_id: cat_id, _token: token};
	console.log(postData);
	$.post(changeUrl, postData, function(data){
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
	$(document).ready(function(){
		$("#cat_id").on("change", changeCat);
		// 
		
		// $('#shopCreate').submit(function(){
		// 	var name = $("#name").val();
		// 	var intro = $("#intro").val();
		// 	var type = $("#type").val();
		// 	var status = $("#status").val();
		// 	var token = $("input[name='_token']").val();
		// 	var postData = {name: name, intro: intro, type: type, status: status, _token: token};
		// 	console.log(postData);

		// 	$.post(url, postData, function(data){
		// 		if(data.errno)
		// 		{
		// 			alert(data.msg);
		// 		}
		// 		else
		// 		{
		// 			alert(data.msg)
		// 		}
				
		// 		console.log(data);
		// 		//表单重置
		// 		document.getElementById('shopCreate').reset();
		// 		//错误提示删除
		// 		$("#namediv").removeClass('has-error');
		// 		$("#introdiv").addClass('has-error');
		// 		$("#typediv").addClass('has-error');
		// 		$("#statusdiv").addClass('has-error');
		// 		$("#namediv .help-block").html("");
		// 		$("#introdiv .help-block").html("");
		// 		$("#typediv .help-block").html("");
		// 		$("#statusdiv .help-block").html("");
		// 	})
		// 	.fail(function(data){
		// 		console.log(data.responseJSON);
		// 		//此处使用js来验证值，我还需要精进下。
		// 		if( data.responseJSON.name[0] != ''){
		// 			$("#namediv").addClass('has-error');
		// 			$("#namediv .help-block").html("<strong>"+data.responseJSON.name[0]+"</strong>");
		// 		}
		// 		if( data.responseJSON.intro[0] != ''){
		// 			$("#introdiv").addClass('has-error');
		// 			$("#introdiv .help-block").html("<strong>"+data.responseJSON.intro[0]+"</strong>");
		// 		}
		// 		if( data.responseJSON.type[0] != ''){
		// 			$("#typediv").addClass('has-error');
		// 			$("#typediv .help-block").html("<strong>请选择节目类型</strong>");
		// 		}
		// 		if( data.responseJSON.status[0] != ''){
		// 			$("#statusdiv").addClass('has-error');
		// 			$("#statusdiv .help-block").html("<strong>请选择节目当前播出状态</strong>");
		// 		}
				
		// 	});
		// 	return false;
		// });
	});
</script>
@endsection

@section('content')
<div id="wrapper">

    @include('admin.layouts.navigation')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">添加商户</h1>
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
        						<form role="form" id="shopCreate" {{-- method="POST" action="{{ url('houtai/shops') --}}">
        							<div class="form-group" id="namediv">
        								<label>商户名称</label>
        								<input type="text" id="name" name="name" class="form-control" placeholder="">

	                                    <span class="help-block">
	                                    </span>
        							</div>
        							<div class="form-group">
                                            <label>商户头图</label>
                                            <input type="file">
                                    </div>
                                    <div class="form-group" id="catdiv">
										<label>商户分类</label>
										<select class="form-control" id="cat_id" name="cat_id">
											<option value="-1">请选择分类</option>
											<option value="0">外卖</option>
										</select>
										<span class="help-block"></span>
									</div>
									<div class="form-group" id="typediv">
										<label>商户子分类</label>
										<select class="form-control" id="type_id" name="type_id">
											<option value="-1">请选择子分类</option>
										</select>
										<span class="help-block"></span>
									</div>
									<div class="form-group" id="teldiv">
        								<label>联系电话</label>
        								<input type="text" id="tel" name="tel" class="form-control" placeholder="">
	                                    <span class="help-block">
	                                    </span>
        							</div>
        							<div class="form-group" id="bossteldiv">
        								<label>老板手机号</label>
        								<input type="text" id="bosstel" name="bosstel" class="form-control" placeholder="">
	                                    <span class="help-block">
	                                    </span>
        							</div>
        							<div class="form-group">
        								<label>营业时间</label>
        								<input type="text" id="open_time" name="open_time" class="form-control" placeholder="">
	                                    <span class="help-block">
	                                    </span>
        							</div>
        							<div class="form-group">
        								<label>地址</label>
        								<input type="text" id="addr" name="addr" class="form-control" placeholder="">
	                                    <span class="help-block">
	                                    </span>
        							</div>
        							<div class="form-group">
                                        <label>是否VIP商户</label>
                                        <label class="radio-inline">
                                            <input type="radio" name="is_vip" value="0" checked>否
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="is_vip" value="1">是
                                        </label>
                                    </div>
									<div class="form-group" id="introdiv">
										<label>老板一句话简介：</label>
										<textarea class="form-control" rows="3" id="intro" name="intro" placeholder=""></textarea>

										<span class="help-block">
	                                    </span>
									</div>
									<div class="form-group">
                                            <label>菜单图</label>
                                            <input type="file">
                                            <input type="file">
                                            <input type="file">
                                            <input type="file">
                                    </div>
									
									{{ csrf_field() }}
									<button type="submit" class="btn btn-success">添加</button>
        						</form>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
@endsection