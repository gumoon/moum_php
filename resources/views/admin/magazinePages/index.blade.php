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
            url: "{{ url('/houtai/spreads') }}"+"/"+id,
            type: 'delete',
            dataType: 'json',
            success: function(data){
                alert(data.msg);
                window.location.href = "{{ url('/houtai/spreads') }}";
            },
            error: function(){
                alert('出错了')
            }
        };
        $("#deleteSpread").ajaxSubmit(options);
    }

    return false;
}

$(document).ready(function(){
	$("#spreadTables").DataTable({
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
                <h1 class="page-header">全部杂志页</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
        			<div class="panel-heading">
        				列表
        			</div>
        			<div class="panel-body">
        				<table  width="100%" class="table table-striped table-bordered table-hover" id="spreadTables">
        					<thead>
        						<tr>
        							<th>ID</th>
        							<th>扩展信息</th>
                                    <th>排序权重</th>
        							<th>图片</th>
        							<th>操作</th>
        						</tr>
        					</thead>
        					<tbody>
        					@forelse ($spreads as $spread)
							    <tr>
        							<td>{{ $spread->id }}</td>
        							<td>{{ $spread->extra }}</td>
                                    <td>{{ $spread->order }}</td>
        							<td><img src="{{ $spread->image_url_src }}" style="width:100px;height: 100px"></td>
        							<td><a href="{{ route('magazinePages.edit', ['spread' => $spread->id]) }}">编辑</a>&nbsp;&nbsp;<a href="javascript;" onclick="destroy({{$spread->id}}); return false;">删除</a></td>
        						</tr>
							@empty
							    <tr>
							    	<td>No spreads</td>
							    </tr>
							@endforelse
        						
        					</tbody>
        				</table>
                        <form id="deleteSpread">        
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success" style="display: none;"></button>
                        </form>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
@endsection