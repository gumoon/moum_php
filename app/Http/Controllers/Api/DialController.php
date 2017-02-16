<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use moum\Models\Dial;
use Config;
use Carbon\Carbon;


class DialController extends Controller
{
    /**
     * @api {get} /dial/shop_timeline 最近打商户电话列表
     * @apiName DialShopTimeline
     * @apiGroup Dial
     *
     * @apiParam {Number} [page=1]
     * @apiParam {Number} [count=10]
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
	public function shopTimeline(Request $request)
	{
		$this->validate($request, [
			'page' => 'bail|filled|integer|min:1',
			'count' => 'bail|filled|integer|min:1'
		]);

		$page = $request->input('page', 1);
		$count = $request->input('count', 10);
		$offset = ($page -1) * $count;

		$dials = Dial::where('shop_id', '>', 0)
					->latest()
					->skip($offset)
					->take($count)
					->get();

		$tmp = array();
		foreach( $dials AS $dial )
		{
			$tmp[] = array(
				'created_at' => Carbon::parse($dial->created_at)->diffForHumans(),
				'shop' => array(
					'id' => $dial->shop->id,
					'name' => $dial->shop->name,
					'image_url' => Config::get('app.ossDomain').$dial->shop->image_url,
					'open_time' => $dial->shop->open_time,
					'intro' => $dial->shop->intro
				),
				'user' => array(
					'name' => $dial->user->name,
				)
			);
		}


		$data = array(
			'dials' => $tmp,
			'amount' => Dial::where('shop_id', '>', 0)->count()
		);

		return $this->successJson( $data );
	}

	/**
	 * @api {post} /dial/create 用户打电话行为发生时调用
	 * @apiName DialCreate
	 * @apiGroup Dial
	 *
	 * @apiParam {Number} [shop_id]
	 * @apiParam {Number} [one14_id] shop_id和one14_id 任选其一
	 * 
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
		$this->validate($request, [
			'shop_id' => 'bail|filled|exists:shops,id',
			'one14_id' => 'bail|filled|exists:one14s,id'
		]);

		$userId = $request->user()->id;
		$clientId = $request->user()->token()->client_id;
		$shopId = $request->input('shop_id');
		$one14Id = $request->input('one14_id');
		if( (empty($shopId) && empty($one14Id))
			||
			(!empty($shopId) && !empty($one14Id)) )
		{
			return $this->failedJson('shop_id|one14_id');
		}

		$uuid = $request->header('uuid');

		$dial = new Dial;
		$dial->user_id = $userId;
		$dial->client_id = $clientId;
		$dial->shop_id = $shopId;
		$dial->one14_id = $one14Id;
		$dial->uuid = $uuid;

		$dial->save();

		return $this->successJson();
	}
	
	/**
     * @api {get} /dial/timeline 最近打电话列表
     * @apiName DialTimeline
     * @apiGroup Dial
     *
     * @apiParam {Number} [page=1]
     * @apiParam {Number} [count=10]
     * 
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object[]} data 实时打电话信息
     * @apiSuccess {Object[]} data.dials 实时打电话详情
     * @apiSuccess {String} data.dials.created_at 打电话时间
     * @apiSuccess {Object} [data.dials.shop] 被打电话的商户(含114企业)
     * @apiSuccess {String} data.dials.shop.name 商户名(含114企业)
     * @apiSuccess {Object} data.dials.user 打电话的用户
     * @apiSuccess {String} data.dials.user.name 用户名
     * @apiSuccess {Number} data.amount 满足条件的总记录条数
     *
     * @apiSuccessExample {json} Success-response:
	 * {
	 *   "err_no": 0,
	 *   "msg": "成功",
	 *   "data": {
	 *     "dials": [
	 *       {
	 *         "created_at": "1 분 전",
	 *         "user": {
	 *           "name": null
	 *         },
	 *         "shop": {
	 *           "name": "aaa",
	 *         }
	 *       },
	 *       {
	 *         "created_at": "7 분 전",
	 *         "user": {
	 *           "name": null
	 *         },
	 *         "shop": {
	 *           "name": "111",
	 *         }
	 *       }
	 *     ],
	 *     "amount": 2
	 *   }
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
		$offset = ($page -1) * $count;

		$dials = Dial::where('id', '>', 0)
					->latest()
					->skip($offset)
					->take($count)
					->get();

		$tmp = array();
		foreach( $dials AS $key => $dial )
		{
			$tmpShop = array();
			$tmpOne14 = array();
			if( $dial->shop )
			{
				$tmpShop = array(
					'name' => $dial->shop->name,
				);
			}
			elseif( $dial->one14 )
			{
				$tmpOne14 = array(
					'name' => $dial->one14->name,
				);
			}

			$tmp[$key] = array(
				'created_at' => Carbon::parse($dial->created_at)->diffForHumans(),
				'user' => array(
					'name' => $dial->user->name,
				)
			);

			if( !empty($tmpShop) )
			{
				$tmp[$key]['shop'] = $tmpShop;
			}
			if( !empty($tmpOne14) )
			{
				$tmp[$key]['shop'] = $tmpOne14;
			}
		}


		$data = array(
			'dials' => $tmp,
			'amount' => Dial::where('id', '>', 0)->count()
		);

		return $this->successJson( $data );
	}
}
