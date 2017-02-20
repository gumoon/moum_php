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
function deleteShop(id){
    var r=confirm("确认删除吗？");
    if( r==true ){
        var url = "{{ url('/houtai/shops/') }}"+"/"+id;
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
                window.location.href = "{{ url('/houtai/shops') }}";
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
                <h1 class="page-header">全部商户</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
        			<div class="panel-heading">
        				商户列表
        			</div>
        			<div class="panel-body">
        				<table  width="100%" class="table table-striped table-bordered table-hover" id="programTables">
        					<thead>
        						<tr>
        							<th>商户ID</th>
        							<th>商户名称</th>
        							<th>分类/子分类</th>
        							<th>商户电话</th>
                                    <th>是否VIP商户</th>
        							<th>操作</th>
        						</tr>
        					</thead>
        					<tbody>
        					@forelse ($shops as $shop)
							    <tr>
        							<td>{{ $shop->id }}</td>
        							<td>{{ $shop->name }}</td>
        							<td>{{ $shopCats[$shop->cat_id] }}/{{ $shopTypes[$shop->cat_id][$shop->type_id] }}</td>
        							<td>{{ $shop->tel }}</td>
                                    <td>@if($shop->is_vip) 是 @else 否 @endif</td>
        							<td><a href="{{ route('shops.edit', ['shop' => $shop->id]) }}">编辑</a>&nbsp;&nbsp;&nbsp;<a href="javascript::void();" onclick="deleteShop({{$shop->id}})">删除</a></td>
        						</tr>
							@empty
							    <tr>
							    	<td>No shops</td>
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