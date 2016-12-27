<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Requests\StoreCommentPost;
use moum\Http\Controllers\Controller;


class CommentController extends Controller
{
    /**
     * @api {get} /comment/by_shop 某个商户的评论列表
     * @apiName CommentByShop
     * @apiGroup Comment
     * 
     * @apiParam  {String} shop_id 商户ID
     * 
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object[]} data 
     * @apiSuccess {Object} data.user
     * @apiSuccess {String} data.user.name 用户名
     * @apiSuccess {String} data.user.profile_image_url 用户头像
     * @apiSuccess {String} data.created_at 创建时间
     * @apiSuccess {Number} data.score 评星
     * @apiSuccess {String} data.content 评论内容
     *
     * @apiSuccessExample {json} Success-Response:
     * {
	 *  "err_no": 0,
	 *  "msg": "success",
	 *  "data": [
	 *    {
	 *      "user": {
	 *        "name": "路人甲",
	 *        "profile_image_url": "http://s.qdcdn.com/cl/13064302,800,450.jpg"
 	 *      },
	 *      "created_at": "5分钟前",
	 *      "score": 4,
	 *      "content": "很好，非常好!"
	 *    }
	 *    ...
	 *  ]
	 * }
     */
	public function byShop(Request $request)
	{
		$shopId = $request->input('shop_id');
		
		for($i = 0; $i < 10; $i++ )
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

	/**
	 * @api {post} /comment/create 添加一条评论
	 * @apiName CommentCreate
	 * @apiGroup Comment
	 *
	 * @apiParam {Number} shop_id 商户ID
	 * @apiParam {Number} [score=3] 评星
	 * @apiParam {String{..255}} content 评论内容
	 *
	 * @apiSuccess {Number} err_no 错误码
	 * @apiSuccess {String} msg 错误信息
	 * @apiSuccess {Object} data 
	 *
	 * @apiSuccessExample {json} Success-Response:
	 * {
	 *  "err_no": 0,
	 *  "msg": "",
	 *  "data": {}
	 * }
 	 * 
	 */
	public function create(StoreCommentPost $request)
	{
		$shopId = $request->input('shop_id');
		$score = $request->input('score');
		$content = $request->input('content');

		$ret = array(
			'err_no' => 0,
			'msg' => '',
			'data' => new \stdClass
		);

		return response()->json($ret);
	}

	/**
	 * @api {get} /comment/timeline 最新评论
	 * @apiName CommentTimeline
	 * @apiGroup Comment
	 *
	 * @apiSuccess {Number} err_no
	 * @apiSuccess {String} msg
	 * @apiSuccess {Object[]} data
	 * @apiSuccess {Object} data.user
	 * @apiSuccess {String} data.user.name
	 * @apiSuccess {String} data.user.profile_image_url
	 * @apiSuccess {Object} data.shop
	 * @apiSuccess {Number} data.shop.id
	 * @apiSuccess {String} data.shop.name
	 * @apiSuccess {String} data.created_at
	 * @apiSuccess {Number} data.score
	 * @apiSuccess {String} data.content
	 *
	 * @apiSuccessExample {json} Success-response:
	 * {
	 *  "err_no": 0,
	 *  "msg": "success",
	 *  "data": [
	 *    {
	 *      "user": {
	 *        "name": "路人甲",
	 *        "profile_image_url": "http://s.qdcdn.com/cl/13064302,800,450.jpg"
	 *      },
	 *      "shop": {
	 *        "id": 1,
	 *        "name": "餐厅名"
	 *      },
	 *      "created_at": "5分钟前",
	 *      "score": 4,
	 *      "content": "很好，非常好!"
	 *    }
	 *  ]
	 * }
	 * 
	 */
	public function timeline(Request $request)
	{
		for($i = 0; $i < 1; $i++ )
		{
			$comments[] = array(
				'user' => array(
					'name' => '路人甲',
					'profile_image_url' => 'http://s.qdcdn.com/cl/13064302,800,450.jpg'
				),
				'shop' => array(
					'id' => 1,
					'name' => '餐厅名'
				),
				'created_at' => '5分钟前',
				'score' => 4,
				'content' => '很好，非常好!'
			);
		}

		return $this->successJson( $comments );
	}
}
