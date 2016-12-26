<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;


class CommentController extends Controller
{
    /**
     * @api {get} /comment/by_shop 进入APP时调用
     * @apiName CommentByShop
     * @apiGroup Comment
     * 
     * @apiParam  {string} shop_id 商户ID
     * 
     * @apiSuccess {int} err_no
     * @apiSuccess {string} msg
     * @apiSuccess {object} data
     */
	public function byShop(Request $request)
	{
		$shopId = $request->input('shop_id');
		
		for($i = 0; $i < 5; $i++ )
		{
			$comments[] = array(
				'user' => array(
					'name' => '路人甲',
					'profile_image_url' => 'http://s.qdcdn.com/cl/13064302,800,450.jpg'
				),
				'created_at' => '5分钟前',
				'score' => 4,
				'content' => '很好，非常好!'
			);
		}

		$ret = array(
			'err_no' => 0,
			'msg' => 'success',
			'data' => $comments,
		);

		return response()->json($ret);
	}
}
