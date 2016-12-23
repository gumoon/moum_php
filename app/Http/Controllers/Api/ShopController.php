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
				'image_url' => 'http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg',
				'score' => 4,
				'comments_count' => 3,
				'type_name' => '韩食快餐',
				'tel' => '18600562137',
				'distance' => 0.81,
				'open_time' => '10:00-22:00'
			);
		}

		$ret = array(
			'err_no' => 0,
			'msg' => '',
			'data' => array(
				'shops' => $tmp,
				'amount' => 10
			),
		);

		return response()->json($ret);
	}

	//周边商户
	public function arround(Request $request)
	{
		$lng = $request->input('lng');
		$lat = $request->input('lat');
		$page = $request->input('page');
		$count = $request->input('count');
		$catId = $request->input('cat_id');
		$typeId = $request->input('type_id');

		$partner = array();
		for($i = 0; $i < 2; $i++)
		{
			$partner[] = array(
				'id' => $i,
				'name' => '年糕火锅',
				'image_url' => 'http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg',
				'score' => 4,
				'comments_count' => 3,
				'type_name' => '韩食快餐',
				'tel' => '18600562137',
				'distance' => 0.81,
				'open_time' => '10:00-22:00'
			);
		}

		$other = array();
		for($i = 0; $i < 10; $i++)
		{
			$other[] = array(
				'id' => $i,
				'name' => '猪蹄丁丁',
				'score' => 2,
				'comments_count' => 0,
				'type_name' => '韩食快餐',
				'tel' => '18600562137',
				'distance' => 81,
				'open_time' => '10:00-22:00'
			);
		}

		$ret = array(
			'err_no' => 0,
			'msg' => '',
			'data' => array(
				'shops' => array(
					'partner' => $partner,
					'other' => $other
				),
				'amount' => 100
			)
		);

		return response()->json($ret);
	}
}
