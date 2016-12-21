<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;


class CommonController extends Controller
{
    //进入app时调用
	public function init(Request $request)
	{
		$ret = array(
				'a' => 'b',
				'c' => 'd'
			);

		return response()->json($ret);
	}
}
