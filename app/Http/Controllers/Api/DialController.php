<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;


class DialController extends Controller
{
    /**
     * @api {get} /dial/timeline 最近打商户电话列表
     * @apiName DialTimeline
     * @apiGroup Dial
     * 
     * 
     */
	public function timeline(Request $request)
	{
		$tmp = array();
		for($i=0; $i<10; $i++)
		{
			$tmp[] = array(
				'created_at' => '刚刚',
				'shop' => array(
					'id' => 10,
					'name' => '年糕火锅',
					'image_url' => 'http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg',
					'tel' => '13911112222'
				),
				'user' => array(
					'name' => '路人甲',
				)
			);
		}

		$ret = array(
			'err_no' => 0,
			'msg' => 'success',
			'data' => array(
				'dials' => $tmp,
				'amount' => 100,
			),
		);

		return response()->json($ret);
	}
}
