@extends('admin.layouts.houtai')

@section('headcss')
<!-- DataTables CSS -->
<link href="{{ asset('admin/vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="{{ asset('admin/vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
@endsection

@section('thirdjs')
<!-- DataTables JavaScript -->
<script src="{{ asset('admin/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/vendor/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
@endsection

@section('customjs')
<script type="text/javascript">
	$(document).ready(function(){
		$("#userTables").DataTable({
			responsive: true,
			"lengthMenu": [[10, 20, -1], [10, 20, "全部"]]
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
                <h1 class="page-header">全部反馈建议</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
        			<div class="panel-heading">
        				反馈建议列表
        			</div>
        			<div class="panel-body">
        				<table  width="100%" class="table table-striped table-bordered table-hover" id="userTables">
        					<thead>
        						<tr>
        							<th>ID</th>
        							<th>用户名</th>
        							<th>手机号(邮箱)</th>
                                    <th>反馈内容</th>
        							<th>反馈时间</th>
        						</tr>
        					</thead>
        					<tbody>
        					@forelse ($suggests as $suggest)
							    <tr>
        							<td>{{ $suggest->id }}</td>
        							<td>{{ $suggest->user->name }}</td>
        							<td>{{ $suggest->user->tel }}</td>
                                    <td>{{ $suggest->content }}</td>
        							<td>{{ $suggest->created_at }}</td>
        						</tr>
							@empty
							    <tr>
							    	<td>No suggests</td>
							    </tr>
							@endforelse
        						
        					</tbody>
        				</table>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
@endsection