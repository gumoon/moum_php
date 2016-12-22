<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;


class DialController extends Controller
{
    //
	public function timeline(Request $request)
	{
		$ret = array(
			'err_no' => 0,
			'msg' => 'success',
			'data' => new \stdClass,
		);

		return response()->json($ret);
	}
}
