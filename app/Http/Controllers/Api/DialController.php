<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use moum\Models\Dial;


class DialController extends Controller
{
    /**
     * @api {get} /dial/timeline 最近打商户电话列表
     * @apiName DialTimeline
     * @apiGroup Dial
     * 
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object[]} data 实时打电话信息
     * @apiSuccess {Object[]} data.dials 实时打电话详情
     * @apiSuccess {String} data.dials.created_at 打电话时间
     * @apiSuccess {Object} data.dials.shop 被打电话的商户
     * @apiSuccess {Number} data.dials.shop.id 商户ID
     * @apiSuccess {String} data.dials.shop.name 商户名
     * @apiSuccess {String} data.dials.shop.image_url 商户头图
     * @apiSuccess {String} data.dials.shop.open_time 营业时间
     * @apiSuccess {String} data.dials.shop.intro 商户简介
     * @apiSuccess {Object} data.dials.user 打电话的用户
     * @apiSuccess {String} data.dials.user.name 用户名
     * @apiSuccess {Number} data.amount 满足条件的总记录条数
     *
     * @apiSuccessExample {json} Success-response:
     * {
	 *  "err_no": 0,
	 *  "msg": "success",
	 *  "data": {
	 *    "dials": [
	 *      {
	 *        "created_at": "刚刚",
	 *        "shop": {
	 *          "id": 10,
	 *          "name": "年糕火锅",
	 *          "image_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
	 *          "open_time": "10:00-22:00",
	 *          "intro": "老板的一句话介绍"
	 *        },
	 *        "user": {
	 *          "name": "路人甲"
	 *        }
	 *      }
	 *      ...
	 *    ],
	 *    "amount": 100
	 *  }
	 * }
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
					'open_time' => '10:00-22:00',
					'intro' => '老板的一句话介绍'
				),
				'user' => array(
					'name' => '路人甲',
				)
			);
		}

		$data = array(
			'dials' => $tmp,
			'amount' => 100
		);

		return $this->successJson( $data );
	}

	/**
	 * @api {get} /dial/by_month 打电话月榜
	 * @apiName DialByMonth
	 * @apiGroup Dial
	 *
	 * @apiSuccess {Number} err_no
	 * @apiSuccess {String} msg
	 * @apiSuccess {Object[]} data
	 * @apiSuccess {Object} data.shop
	 * @apiSuccess {Number} data.shop.id
	 * @apiSuccess {String} data.shop.tel
	 * @apiSuccess {String} data.shop.name
	 * @apiSuccess {Number} data.count
	 *
	 * @apiSuccessExample {json} Success-response:
	 * {
	 *  "err_no": 0,
	 *  "msg": "success",
	 *  "data": [
	 *    {
	 *      "shop": {
	 *        "id": 1,
	 *        "tel": "13911112222",
	 *        "name": "店铺名称",
	 *        "image_url": "http://i1.hdslb.com/bfs/archive/5b269a158687ae21083778799ac9e939d335ab35.jpg"
	 *      },
	 *      "count": 3215
	 *    }
	 *    ...
	 *  ]
	 * }
	 */
	public function byMonth(Request $request)
	{
		for($i=0; $i<10; $i++)
		{
			$tmp[] = array(
				'shop' => array(
					'id' => 1,
					'tel' => '13911112222',
					'name' => '店铺名称',
					'image_url' => 'http://i1.hdslb.com/bfs/archive/5b269a158687ae21083778799ac9e939d335ab35.jpg'
				),
				'count' => 3215
			);
		}

		return $this->successJson( $tmp );
	}

	/**
	 * @api {post} /dial/create 用户给商户打电话行为发生时调用
	 * @apiName DialCreate
	 * @apiGroup Dial
	 *
	 * @apiParam {Number} shop_id
	 * @apiParam {String} uuid
	 * @apiSuccess {Number} err_no 
	 * @apiSuccess {String} msg
	 * @apiSuccess {Object} data
	 * @apiSuccessExample {json} Success-response: 
	 * {
	 *  "err_no": 0,
	 *  "msg": "success",
	 *  "data": {}
	 * }
	 */
	public function create(Request $request)
	{
		$userId = $request->user()->id;
		$clientId = $request->user()->token()->client_id;
		$shopId = $request->input('shop_id');
		$uuid = $request->input('uuid');

		$this->validate($request, [
			'shop_id' => 'bail|required|exists:shops,id',
			'uuid' => 'required|max:100'
		]);

		$dial = new Dial;
		$dial->uid = $userId;
		$dial->client_id = $clientId;
		$dial->shop_id = $shopId;
		$dial->uuid = $uuid;

		$dial->save();

		return $this->successJson();
	}
	
}
