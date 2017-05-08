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
function deleteOne14(id){
    var r=confirm("确认删除吗？");
    if( r==true ){
        var url = "{{ url('/houtai/one14s/') }}"+"/"+id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            type: 'delete',
            dataType: 'json',
            success: function(data){
                console.log(data);
                window.location.href = "{{ url('/houtai/one14s') }}";
            },
            error: function(){
                alert('出错了');
            }
        });

        return false;        
    }
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
                <h1 class="page-header">全部114企业</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
        			<div class="panel-heading">
        				114企业列表
        			</div>
        			<div class="panel-body">
        				<table  width="100%" class="table table-striped table-bordered table-hover" id="programTables">
        					<thead>
        						<tr>
        							<th>ID</th>
									<th>地区</th>
        							<th>名称</th>
        							<th>分类/子分类</th>
        							<th>电话</th>
                                    <th>是否VIP</th>
        							<th>操作</th>
        						</tr>
        					</thead>
        					<tbody>
        					@forelse ($one14s as $one14)
							    <tr>
        							<td>{{ $one14->id }}</td>
									<td>@if($one14->area_id == 1)北京 @else 燕郊 @endif</td>
        							<td>{{ $one14->name }}</td>
        							<td>{{ $one14->cat_name }}/{{ $one14->type_name }}</td>
        							<td>{{ $one14->tel }}</td>
                                    <td>@if($one14->is_vip) 是 @else 否 @endif</td>
        							<td><a href="{{ route('one14s.edit', ['one14' => $one14->id]) }}">编辑</a>&nbsp;&nbsp;&nbsp;<a href="javascript::void();" onclick="deleteOne14({{$one14->id}})">删除</a></td>
        						</tr>
							@empty
							    <tr>
							    	<td>No 114企业列表</td>
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