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
		var url = "{{ url('houtai/ajax/programinfos/store') }}";
		
		$('#programInfoCreate').submit(function(){
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
                <h1 class="page-header">添加节目内容</h1>
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
        						<form role="form" id="programInfoCreate"">
        							<div class="form-group">
        								<label>标题：</label>
        								<input type="text" id="title" name="title" class="form-control" placeholder="请输入VOA官网上的节目标题，用英文输入">
        							</div>
									<div class="form-group">
										<label>发布日期：</label>
										<input type="date" name="publish_date" id="publish_date" class="form-control">
									</div>
									<div class="form-group">
										<label>头图链接：</label>
										<input type="text" name="image_url" id="image_url" class="form-control">
									</div>
									<div class="form-group">
										<label>多媒体链接：</label>
										<input type="text" name="media_url" id="media_url" class="form-control">
									</div>
									<div class="form-group">
										<label>简介：</label>
										<textarea class="form-control" name="summary" id="summary"></textarea>
									</div>
									
									<div class="form-group">
										<label>新单词</label>
										<textarea class="form-control" id="new_words" name="new_words"></textarea>
									</div>
									
									<div class="form-group">
										<label>节目：</label>
										<select class="form-control" id="type" name="type">
											<option value="-1">请选择节目</option>
											@foreach ($programs as $program)
											<option value="{{ $program->id }}">{{ $program->name }}</option>
											@endforeach
										</select>
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