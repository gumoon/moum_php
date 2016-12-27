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
	$(document).ready(function(){
		var url = "{{ url('houtai/ajax/programs/store') }}";
		
		$('#programCreate').submit(function(){
			var name = $("#name").val();
			var intro = $("#intro").val();
			var type = $("#type").val();
			var status = $("#status").val();
			var token = $("input[name='_token']").val();
			var postData = {name: name, intro: intro, type: type, status: status, _token: token};
			console.log(postData);

			$.post(url, postData, function(data){
				if(data.errno)
				{
					alert(data.msg);
				}
				else
				{
					alert(data.msg)
				}
				
				console.log(data);
				//表单重置
				document.getElementById('programCreate').reset();
				//错误提示删除
				$("#namediv").removeClass('has-error');
				$("#introdiv").addClass('has-error');
				$("#typediv").addClass('has-error');
				$("#statusdiv").addClass('has-error');
				$("#namediv .help-block").html("");
				$("#introdiv .help-block").html("");
				$("#typediv .help-block").html("");
				$("#statusdiv .help-block").html("");
			})
			.fail(function(data){
				console.log(data.responseJSON);
				//此处使用js来验证值，我还需要精进下。
				if( data.responseJSON.name[0] != ''){
					$("#namediv").addClass('has-error');
					$("#namediv .help-block").html("<strong>"+data.responseJSON.name[0]+"</strong>");
				}
				if( data.responseJSON.intro[0] != ''){
					$("#introdiv").addClass('has-error');
					$("#introdiv .help-block").html("<strong>"+data.responseJSON.intro[0]+"</strong>");
				}
				if( data.responseJSON.type[0] != ''){
					$("#typediv").addClass('has-error');
					$("#typediv .help-block").html("<strong>请选择节目类型</strong>");
				}
				if( data.responseJSON.status[0] != ''){
					$("#statusdiv").addClass('has-error');
					$("#statusdiv .help-block").html("<strong>请选择节目当前播出状态</strong>");
				}
				
			});
			return false;
		});
	});
</script>
@endsection

@section('content')
<div id="wrapper">

    @include('admin.layouts.navigation')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">添加节目</h1>
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
        						<form role="form" id="programCreate" {{-- method="POST" action="{{ url('houtai/programs') --}}">
        							<div class="form-group" id="namediv">
        								<label>节目名称：</label>
        								<input type="text" id="name" name="name" class="form-control" placeholder="请输入VOA官网上的节目标准名称，用英文输入">

	                                    <span class="help-block">
	                                    </span>
        							</div>
									<div class="form-group" id="introdiv">
										<label>节目简介：</label>
										<textarea class="form-control" rows="3" id="intro" name="intro" placeholder="节目的英文介绍"></textarea>

										<span class="help-block">
	                                    </span>
									</div>
									<div class="form-group" id="typediv">
										<label>节目类型：</label>
										<select class="form-control" id="type" name="type">
											<option value="-1">请选择节目类型</option>
											<option value="1">音频节目</option>
											<option value="2">视频节目</option>
											<option value="3">音视频节目</option>
											<option value="0">其他类型</option>
										</select>

										<span class="help-block">
	                                    </span>
									</div>
									<div class="form-group" id="statusdiv">
										<label>节目当前播出状态：</label>
										<select class="form-control" id="status" name="status">
											<option value="-1">请选择节目当前播出状态</option>
											<option value="0">正常播出</option>
											<option value="1">已停播</option>
											<option value="99">我们平台已下架</option>
										</select>

										<span class="help-block">
	                                    </span>
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