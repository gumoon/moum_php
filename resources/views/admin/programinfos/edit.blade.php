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
		var url = "{{ url('houtai/ajax/programs/update/') }}";
		var id = $('#programId').val();
		url = url + '/' + id;

		$('#programEdit').submit(function(){
			var name = $("#name").val();
			var intro = $("#intro").val();
			var type = $("#type").val();
			var status = $("#status").val();
			var token = $("input[name='_token']").val();
			var postData = {name: name, intro: intro, type: type, status: status, _token: token};
			console.log(postData);
			
			$.post(url, postData, function(data){
				console.log(data);

				if(data.errno)
				{
					alert(data.msg);
				}
				else
				{
					alert(data.msg)
				}
				window.location.href = "{{ route('programs.index') }}";
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
                <h1 class="page-header">编辑节目</h1>
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
        						<form role="form" id="programEdit">
        							<div class="form-group">
        								<label>节目名称：</label>
        								<input type="text" id="name" name="name" class="form-control" placeholder="请输入VOA官网上的节目标准名称，用英文输入" value="{{ $program->name }}">
        							</div>
									<div class="form-group">
										<label>节目简介：</label>
										<textarea class="form-control" rows="3" id="intro" name="intro" placeholder="节目的英文介绍">{{ $program->intro }}</textarea>
									</div>
									<div class="form-group">
										<label>节目类型：</label>
										<select class="form-control" id="type" name="type">
											<option value="-1">请选择节目类型</option>
											<option value="1" @if ($program->type == 1) selected @endif >音频节目</option>
											<option value="2" @if ($program->type == 2) selected @endif >视频节目</option>
											<option value="3" @if ($program->type == 3) selected @endif >音视频节目</option>
											<option value="0" @if ($program->type == 0) selected @endif >其他类型</option>
										</select>
									</div>
									<div class="form-group">
										<label>节目当前播出状态：</label>
										<select class="form-control" id="status" name="status">
											<option value="-1">请选择节目当前播出状态</option>
											<option value="0" @if ($program->status == 0) selected @endif >正常播出</option>
											<option value="1" @if ($program->status == 1) selected @endif >已停播</option>
											<option value="99" @if ($program->status == 99) selected @endif >我们平台已下架</option>
										</select>
									</div>
									{{ csrf_field() }}
									<input type="hidden" name="id" id="programId" value="{{ $program->id }}">
									<button type="submit" class="btn btn-success">确认修改</button>
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