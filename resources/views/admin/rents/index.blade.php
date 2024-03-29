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
<script type="text/javascript" src="{{ asset('admin/data/jquery.form.js') }}"></script>
@endsection

@section('customjs')
<script type="text/javascript">
function destroy(id)
{
    var r = confirm('确认删除吗？');
    if(r == true)
    {
        var options = {
            url: "{{ url('/houtai/rents') }}"+"/"+id,
            type: 'delete',
            dataType: 'json',
            success: function(data){
                alert(data.msg);
                window.location.href = "{{ url('/houtai/rents') }}";
            },
            error: function(){
                alert('出错了')
            }
        };
        $("#deleteRent").ajaxSubmit(options);
    }

    return false;
}

	$(document).ready(function(){
		$("#programTables").DataTable({
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
                <h1 class="page-header">全部出租房源</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
        			<div class="panel-heading">
        				出租房源列表
        			</div>
        			<div class="panel-body">
        				<table  width="100%" class="table table-striped table-bordered table-hover" id="programTables">
        					<thead>
        						<tr>
        							<th>ID</th>
        							<th>标题</th>
        							<th>电话</th>
                                    <th>是否已租出</th>
        							<th>操作</th>
        						</tr>
        					</thead>
        					<tbody>
        					@forelse ($rents as $rent)
							    <tr>
        							<td>{{ $rent->id }}</td>
        							<td>{{ $rent->title }}</td>
        							<td>{{ $rent->tel }}</td>
                                    <td>@if($rent->is_rented) 是 @else 否 @endif</td>
        							<td><a href="{{ route('rents.edit', ['rent' => $rent->id]) }}">编辑</a>&nbsp;&nbsp;<a href="javascript;" onclick="destroy({{$rent->id}}); return false;">删除</a></td>
        						</tr>
							@empty
							    <tr>
							    	<td>No shops</td>
							    </tr>
							@endforelse
        						
        					</tbody>
        				</table>
                        <form id="deleteRent">        
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success" style="display: none;"></button>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
@endsection