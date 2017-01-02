<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Models\Shop;
use moum\Http\Controllers\Controller;


class ShopController extends Controller
{
    /**
     * @api {get} /shop/recommend 推荐商家
     * @apiName ShopRecommend
     * @apiGroup Shop
     *
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object} data 
     * @apiSuccess {Object[]} data.shops 商户l列表
     * @apiSuccess {Number} data.shops.id 商户ID
     * @apiSuccess {String} data.shops.name 商户名
     * @apiSuccess {String} data.shops.image_url 商户头图
     * @apiSuccess {Number} data.shops.score 评星
     * @apiSuccess {Number} data.shops.coumments_count 评论数
     * @apiSuccess {String} data.shops.type_name 子类名
     * @apiSuccess {String} data.shops.tel 电话号
     * @apiSuccess {Number} data.shops.distance 距离
     * @apiSuccess {String} data.shops.open_time 营业时间
     * @apiSuccess {Number} data.amount 满足条件的商户总数
     *
     * @apiSuccessExample {json} Success-response:
     * {
	 *  "err_no": 0,
	 *  "msg": "",
	 *  "data": {
	 *    "shops": [
	 *      {
	 *        "id": 0,
	 *        "name": "年糕火锅",
	 *        "image_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
	 *        "score": 4,
	 *        "comments_count": 3,
	 *        "type_name": "韩食快餐",
	 *        "tel": "18600562137",
	 *        "distance": 0.81,
	 *        "open_time": "10:00-22:00"
	 *      }
	 *      ...
	 *    ],
	 *    "amount": 10
	 *  }
	 * }
     */
	public function recommend(Request $request)
	{
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

		$data = array(
			'shops' => $tmp,
			'amount' => 10
		);

		return $this->successJson( $data );
	}

	/**
	 * @api {get} /shop/timeline 最新商户列表
	 * @apiName ShopTimeline
	 * @apiGroup Shop
	 *
	 * @apiSuccess {Number} err_no
	 * @apiSuccess {String} msg
	 * @apiSuccess {Object[]} data
	 * @apiSuccess {Number} data.id
	 * @apiSuccess {String} data.name
	 * @apiSuccess {String} data.image_url
	 * @apiSuccess {String} data.created_at
	 * @apiSuccess {String} data.intro
	 *
	 * @apiSuccessExample {json} Success-response:
	 * {
	 *  "err_no": 0,
	 *  "msg": "",
	 *  "data": [
	 *    {
	 *      "id": 0,
	 *      "name": "年糕火锅",
	 *      "image_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
	 *      "created_at": "5小时前",
	 *      "intro": "老板的一句话介绍"
	 *    }
	 *    ...
	 *  ]
	 * }
	 */
	public function timeline(Request $request)
	{
		for($i = 0; $i < 10; $i++)
		{
			$tmp[] = array(
				'id' => $i,
				'name' => '年糕火锅',
				'image_url' => 'http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg',
				'created_at' => '5小时前',
				'intro' => '老板的一句话介绍'
			);
		}

		return $this->successJson( $tmp );		
	}

	/**
	 * @api {get} /shop/arround 周边商户列表
	 * @apiName ShopArround
	 * @apiGroup Shop
	 *
	 * @apiParam {Number} lng 经度
	 * @apiParam {Number} lat 维度
	 * @apiParam {Number} [page=1] 页码
	 * @apiParam {Number} [count=10] 每页商户数
	 * @apiParam {Number} type_id 类型ID
	 *
	 * @apiSuccess {Number} err_no 错误码
	 * @apiSuccess {String} msg 错误信息
	 * @apiSuccess {Object} data
	 * @apiSuccess {Object[]} data.partner
	 * @apiSuccess {Number} data.partner.id 商户ID
	 * @apiSuccess {String} data.partner.name 商户名
	 * @apiSuccess {String} data.partner.image_url 商户头图
	 * @apiSuccess {Number} data.partner.score 评星
	 * @apiSuccess {Number} data.partner.comments_count 商户评价数
	 * @apiSuccess {String} data.partner.type_name 类型名
	 * @apiSuccess {String} data.partner.tel 商户电话
	 * @apiSuccess {Number} data.partner.distance 距离
	 * @apiSuccess {String} data.partner.open_time 营业时间
	 * @apiSuccess {Object[]} data.other
	 * @apiSuccess {Number} data.other.id 商户ID
	 * @apiSuccess {String} data.other.name 商户名
	 * @apiSuccess {Number} data.other.score 评星
	 * @apiSuccess {Number} data.other.comments_count 商户评价数
	 * @apiSuccess {String} data.other.type_name 类型名
	 * @apiSuccess {String} data.other.tel 商户电话
	 * @apiSuccess {Number} data.other.distance 距离
	 * @apiSuccess {String} data.other.open_time 营业时间
	 * @apiSuccess {Number} data.amount 满足条件的商户总数
	 *
	 * @apiSuccessExample {json} Success-response:
	 * {
	 *  "err_no": 0,
	 *  "msg": "",
	 *  "data": {
	 *    "shops": {
	 *      "partner": [
	 *        {
	 *          "id": 0,
	 *          "name": "年糕火锅",
	 *          "image_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
	 *          "score": 4,
	 *          "comments_count": 3,
	 *          "type_name": "韩食快餐",
	 *          "tel": "18600562137",
	 *          "distance": 0.81,
	 *          "open_time": "10:00-22:00"
	 *        }
	 *        ...
	 *      ],
	 *      "other": [
	 *        {
	 *          "id": 0,
	 *          "name": "猪蹄丁丁",
	 *          "score": 2,
	 *          "comments_count": 0,
	 *          "type_name": "韩食快餐",
	 *          "tel": "18600562137",
	 *          "distance": 81,
	 *          "open_time": "10:00-22:00"
	 *        }
	 *        ...
	 *      ]
	 *    },
	 *    "amount": 100
	 *  }
	 * }
	 */
	public function arround(Request $request)
	{
		$lng = $request->input('lng');
		$lat = $request->input('lat');
		$page = $request->input('page');
		$count = $request->input('count');
		$typeId = $request->input('type_id');

		$partner = array();
		for($i = 0; $i < 10; $i++)
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

		$data = array(
			'shops' => array(
				'partner' => $partner,
				'other' => $other
			),
			'amount' => 100
		);

		return $this->successJson( $data );
	}

	/**
	 * @api {get} /shop/search 商户搜索
	 * @apiName ShopSearch
	 * @apiGroup Shop
	 *
	 * @apiParam {String} keyword 查询关键字
	 * 
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object} data 
     * @apiSuccess {Object[]} data.shops 商户l列表
     * @apiSuccess {Number} data.shops.id 商户ID
     * @apiSuccess {String} data.shops.name 商户名
     * @apiSuccess {String} data.shops.image_url 商户头图
     * @apiSuccess {Number} data.shops.score 评星
     * @apiSuccess {Number} data.shops.coumments_count 评论数
     * @apiSuccess {String} data.shops.type_name 子类名
     * @apiSuccess {String} data.shops.tel 电话号
     * @apiSuccess {Number} data.shops.distance 距离
     * @apiSuccess {String} data.shops.open_time 营业时间
     * @apiSuccess {Number} data.amount 满足条件的商户总数
	 *
	 * @apiSuccessExample {json} Success-response:
     * {
	 *  "err_no": 0,
	 *  "msg": "",
	 *  "data": {
	 *    "shops": [
	 *      {
	 *        "id": 0,
	 *        "name": "年糕火锅",
	 *        "image_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
	 *        "score": 4,
	 *        "comments_count": 3,
	 *        "type_name": "韩食快餐",
	 *        "tel": "18600562137",
	 *        "distance": 0.81,
	 *        "open_time": "10:00-22:00"
	 *      }
	 *      ...
	 *    ],
	 *    "amount": 10
	 *  }
	 * }
	 * 
	 */
	public function search(Request $request)
	{
		$keyword = $request->input('keyword');

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

		$data = array(
			'shops' => $tmp,
			'amount' => 100
		);

		return $this->successJson( $data );
	}

	/**
	 * @api {get} /shop/show 单个商户详情
	 * @apiName ShopShow
	 * @apiGroup Shop
	 *
	 * @apiParam {Number} shop_id 商户ID
	 *
	 * @apiSuccess {Number} err_no 错误码
	 * @apiSuccess {String} msg 错误信息
	 * @apiSuccess {Object} data
	 * @apiSuccess {Number} data.id 商户ID
	 * @apiSuccess {String} data.name 商户名称
	 * @apiSuccess {Number} data.score 评星
	 * @apiSuccess {Number} data.comments_count 评论数
	 * @apiSuccess {String} data.type_name 类型名
	 * @apiSuccess {String} data.tel 商户电话
	 * @apiSuccess {Number} data.distance 距离
	 * @apiSuccess {String} data.open_time 营业时间
	 * @apiSuccess {String} data.image_url 商户头图
	 * @apiSuccess {String[]} data.menu_image_urls 菜单图们
	 *
	 * @apiSuccessExample {json} Success-response:
	 * {
	 *  "err_no": 0,
	 *  "msg": "",
	 *  "data": {
	 *    "id": 10,
	 *    "name": "年糕火锅",
	 *    "score": 2,
	 *    "comments_count": 0,
	 *    "type_name": "韩食快餐",
	 *    "tel": "18600562137",
	 *    "distance": 81,
	 *    "open_time": "10:00-22:00",
	 *    "image_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
	 *    "intro": "老板的一句话介绍",
	 *    "addr": "北京市海淀区五道口人民街50号",
	 *    "menu_image_urls": [
	 *      "http://cdn.duitang.com/uploads/item/201405/31/20140531173512_fsKam.jpeg",
	 *      "http://img4q.duitang.com/uploads/item/201407/29/20140729224422_Wrrhi.jpeg"
	 *    ]
	 *  }
	 * }
	 */
	public function show(Request $request)
	{
		$shopId = $request->input('shop_id');

		// $shop = Shop::find( $shopId );

		$shop = array(
			'id' => 10,
			'name' => '年糕火锅',
			'score' => 2,
			'comments_count' => 0,
			'type_name' => '韩食快餐',
			'tel' => '18600562137',
			'distance' => 81,
			'open_time' => '10:00-22:00',
			'image_url' => 'http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg',
			'intro' => '老板的一句话介绍',
			'addr' => '北京市海淀区五道口人民街50号',
			'menu_image_urls' => array(
				'http://cdn.duitang.com/uploads/item/201405/31/20140531173512_fsKam.jpeg',
				'http://img4q.duitang.com/uploads/item/201407/29/20140729224422_Wrrhi.jpeg'
			)
		);

		return $this->successJson( $shop );
	}

	/**
	 * @api {post} /shop/report_error 商户纠错
	 * @apiName ShopHasError
	 * @apiGroup Shop
	 *
	 * @apiParam {Number}  err_num 错误号
	 *
	 * @apiSuccess {Number} err_no 错误码
	 * @apiSuccess {String} msg 错误信息
	 * @apiSuccess {Object} data
 	 *
 	 * @apiSuccessExample {json} Success-response:
 	 * {
	 *  "err_no": 0,
	 *  "msg": "",
	 *  "data": {}
	 * }
	 */
	public function reportError(Request $request)
	{
		$errorNo = $request->input('err_num');

		return $this->successJson();
	}
}
