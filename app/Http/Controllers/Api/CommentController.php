<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Requests\StoreCommentPost;
use moum\Models\Comment;
use moum\Models\Shop;
use moum\Http\Controllers\Controller;


class CommentController extends Controller
{
    /**
     * @api {get} /comment/by_shop 某个商户的评论列表（支持分页）
     * @apiName CommentByShop
     * @apiGroup Comment
     * 
     * @apiParam {String} shop_id 商户ID
     * @apiParam {Number} [page=1] 页码
     * @apiParam {Number} [count=10] 每页多少条记录
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
		$this->validate($request, [
			'shop_id' => 'bail|required|exists:shops,id',
			'page' => 'bail|filled|integer|min:1',
			'count' => 'bail|filled|integer|min:1'
		]);

		$shopId = $request->input('shop_id');
		$page = $request->input('page', 1);
		$count = $request->input('count', 10);
		$offset = ($page - 1) * $count;

		$comments = Comment::where('shop_id', $shopId)
						->latest()
						->skip($offset)
						->take($count)
						->get();

		$tmp = array();
		foreach( $comments AS $comment )
		{
			$tmp[] = array(
				'user' => array(
					'name' => $comment->user->name,
					'profile_image_url' => 'http://v1.qzone.cc/avatar/201506/13/09/57/557b8e21c827c327.jpg%21200x200.jpg'
				),
				'created_at' => empty($comment->created_at) ? '未知' : $comment->created_at->diffForHumans(),
				'score' => $comment->score,
				'content' => $comment->content
			);
		}
		
		return $this->successJson( $tmp );
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
		$this->validate($request, [
			'shop_id' => 'bail|required|exists:shops,id',
			'score' => 'bail|filled|integer|in:1,2,3,4,5',
			'content' => 'bail|required|max:255'
		]);

		$shopId = $request->input('shop_id');
		$score = $request->input('score', 3);
		$content = $request->input('content');
		$userId = $request->user()->id;

		$comment = new Comment;
		$comment->score = $score;
		$comment->content = $content;
		$comment->user_id = $userId;

		$shop = Shop::findOrFail( $shopId );

		$shop->comments()->save( $comment );

		return $this->successJson();
	}

	/**
	 * @api {get} /comment/timeline 最新评论
	 * @apiName CommentTimeline
	 * @apiGroup Comment
	 *
	 * @apiParam {Number} [page=1]
	 * @apiParam {Number} [count=10]
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
		$this->validate($request, [
			'page' => 'bail|filled|integer|min:1',
			'count' => 'bail|filled|integer|min:1'
		]);
		
		$page = $request->input('page', 1);
		$count = $request->input('count', 10);
		$offset = ($page - 1) * $count;

		//按照时间戳，查询最新的评论列表
		$comments = Comment::where('id', '>', 0)
						->latest()
						->skip($offset)
						->take($count)
						->get();

		$tmp = array();
		foreach( $comments AS $comment)
		{
			$tmp[] = array(
				'user' => array(
					'name' => $comment->user->name,
					'profile_image_url' => 'http://s.qdcdn.com/cl/13064302,800,450.jpg'
				),
				'shop' => array(
					'id' => $comment->shop->id,
					'name' => $comment->shop->name
				),
				'created_at' => $comment->created_at->diffForHumans(),
				'score' => $comment->score,
				'content' => $comment->content
			);
		}

		return $this->successJson( $tmp );
	}
}
