<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;


class ShopController extends Controller
{
    //
	public function recommend(Request $request)
	{
		// $ret = array(
		// 	'err_no' => 0,
		// 	'msg' => 'success',
		// 	'data' => new \stdClass,
		// );

		for($i = 0; $i < 10; $i++)
		{
			$tmp[] = array(
				'id' => $i,
				'name' => '年糕火锅',
				'image' => '',
				'score' => 4,
				'comment_count' => 3,
				'type_name' => '韩食快餐',
				'tel' => '18600562137',
				'distance' => 0.81,
			);
		}

		$ret = array(
			'err_no' => 0,
			'msg' => '',
			'data' => array(
				'shops' => $tmp,
				'count' => 10
			),
		);

		return response()->json($ret);
	}
}
