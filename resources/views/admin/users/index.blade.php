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
                <h1 class="page-header">全部用户</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
        			<div class="panel-heading">
        				用户列表
        			</div>
        			<div class="panel-body">
        				<table  width="100%" class="table table-striped table-bordered table-hover" id="userTables">
        					<thead>
        						<tr>
        							<th>ID</th>
        							<th>名称</th>
        							<th>手机号</th>
                                    <th>注册时间</th>
        							<th>操作</th>
        						</tr>
        					</thead>
        					<tbody>
        					@forelse ($users as $user)
							    <tr>
        							<td>{{ $user->id }}</td>
        							<td>{{ $user->name }}</td>
        							<td>{{ $user->tel }}</td>
                                    <td>{{ $user->created_at }}</td>
        							<td><a href="{{ route('users.edit', ['user' => $user->id]) }}">编辑</a></td>
        						</tr>
							@empty
							    <tr>
							    	<td>No users</td>
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