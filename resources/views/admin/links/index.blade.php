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

function deleteLink(id){
    var r=confirm("确认删除吗？");
    if( r==true ){
        var url = "{{ url('/houtai/links/') }}"+"/"+id;
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
                window.location.href = "{{ url('/houtai/links') }}";
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
                <h1 class="page-header">全部网址</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
        			<div class="panel-heading">
        				网址列表
        			</div>
        			<div class="panel-body">
        				<table  width="100%" class="table table-striped table-bordered table-hover" id="programTables">
        					<thead>
        						<tr>
                                    <th>国家</th>
        							<th>名称</th>
        							<th>URL</th>
                                    <th>图标</th>
        							<th>操作</th>
        						</tr>
        					</thead>
        					<tbody>
        					@forelse ($links as $link)
							    <tr>
        							<td>@if($link->nation_id == 0)中国@elseif($link->nation_id == 1)韩国@endif</td>
        							<td>{{ $link->name }}</td>
        							<td>{{ $link->url }}</td>
                                    <td><img src="{{ $link->icon_src }}" style="width: 50px;height: 50px;"></td>
        							<td><a href="{{ route('links.edit', ['link' => $link->id]) }}">编辑</a>&nbsp;&nbsp;&nbsp;<a href="javascript::void();" onclick="deleteLink({{$link->id}})">删除</a></td>
        						</tr>
							@empty
							    <tr>
							    	<td>No links</td>
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