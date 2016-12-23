<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;


class LinkController extends Controller
{
    //
	public function all(Request $request)
	{
		for ($i=0; $i < 10; $i++) 
		{ 
			$tmp1[] = array(
				'icon' => '',
				'name' => '百度',
				'url' => 'http://www.baidu.com'
			);
		}
		
		$links = array(
			'china' => $tmp1,
			'korea' => $tmp1
		);

		$ret = array(
			'err_no' => 0,
			'msg' => 'success',
			'data' => $links,
		);

		return response()->json($ret);
	}
}
