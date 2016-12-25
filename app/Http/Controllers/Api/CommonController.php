<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;


class CommonController extends Controller
{
    /**
     * 进入APP时调用
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function init(Request $request)
	{
		//设备唯一标识符
		$uuid = $request->input('uuid');
		
		$ret = array(
			'err_no' => 0,
			'msg' => 'success',
			'data' => new \stdClass,
		);

		return response()->json($ret);
	}
}
