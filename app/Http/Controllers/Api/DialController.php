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
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object[]} data 实时打电话信息
     * @apiSuccess {Object[]} data.dials 实时打电话详情
     * @apiSuccess {String} data.dials.created_at 打电话时间
     * @apiSuccess {Object} data.dials.shop 被打电话的商户
     * @apiSuccess {Number} data.dials.shop.id 商户ID
     * @apiSuccess {String} data.dials.shop.name 商户名
     * @apiSuccess {String} data.dials.shop.image_url 商户头图
     * @apiSuccess {String} data.dials.shop.tel 商户电话
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
	 *          "tel": "13911112222"
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
		for($i=0; $i<1; $i++)
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
