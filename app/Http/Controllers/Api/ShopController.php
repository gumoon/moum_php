<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Models\Shop;
use Config;
use DB;
use moum\Models\AccessShop;
use moum\Services\Helper;
use moum\Http\Controllers\Controller;
use Carbon\Carbon;
use moum\Events\AccessShopEvent;
use moum\Models\Spread;

class ShopController extends Controller
{
    /**
     * @api {get} /shop/recommend 推荐商家
     * @apiName ShopRecommend
     * @apiGroup Shop
     *
     * @apiParam {Number} lat
     * @apiParam {Number} lng
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
		$this->validate($request, [
			'lat' => 'bail|required|min:-90|max:90',
			'lng' => 'bail|required|min:-180|max:180'
		]);

		$lat = $request->input('lat');
		$lng = $request->input('lng');

		$spreads = Spread::where('position_id', 0)
					->orderBy('order', 'desc')
					->get();
		$shopIds = $spreads->keyBy('extra')->keys()->all();

		$shops = Shop::whereIn('id', $shopIds)
						->get();

		$tmp = array();
		$distance = '';
		foreach( $shops AS $shop )
		{
			if( !empty($lng) && !empty($lat) )
			{
				$distance = Helper::getDistance($shop->lng, $shop->lat, $lng, $lat).'km';
			}

			$tmp[] = array(
				'id' => $shop->id,
				'name' => $shop->name,
				'image_url' => Config::get('app.ossDomain').$shop->image_url,
				'score' => 4,
				'comments_count' => $shop->comments->count(),
				'type_name' => $this->shopTypes[$shop->cat_id][$shop->type_id],
				'tel' => $shop->tel,
				'distance' => $distance,
				'open_time' => $shop->open_time
			);
		}	

		$data = array(
			'shops' => $tmp,
			'amount' => count($shopIds)
		);

		return $this->successJson( $data );
	}

	/**
	 * @api {get} /shop/timeline 最新商户列表
	 * @apiName ShopTimeline
	 * @apiGroup Shop
	 *
	 * @apiParam {Number} [page=1]
	 * @apiParam {Number} [count=10]
	 * @apiParam {Number} lat
	 * @apiParam {Number} lng
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
		$this->validate($request, [
			'page' => 'bail|filled|integer|min:1',
			'count' => 'bail|filled|integer|min:1',
			'lat' => 'bail|required|min:-90|max:90',
			'lng' => 'bail|required|min:-180|max:180'
		]);
		
		$page = $request->input('page', 1);
		$count = $request->input('count', 10);
		$offset = ($page - 1) * $count;
		$lat = $request->input('lat');
		$lng = $request->input('lng');

		//按照时间戳，查询最新的商户列表
		$shops = Shop::where('id', '>', 0)
						->latest()
						->skip($offset)
						->take($count)
						->get();

		$tmp = array();
		$distance = '';
		foreach( $shops AS $shop )
		{
			if( !empty($lng) && !empty($lat) )
			{
				$distance = Helper::getDistance($shop->lng, $shop->lat, $lng, $lat).'km';
			}

			$tmp[] = array(
				'id' => $shop->id,
				'name' => $shop->name,
				'image_url' => Config::get('app.ossDomain').$shop->image_url,
				'created_at' => $shop->created_at->diffForHumans(),
				'intro' => $shop->intro,
				'open_time' => $shop->open_time,
				'distance' => $distance
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
	 * @apiParam {Number} type_id 类型ID:0-4,全部时传99
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
		$this->validate($request, [
			'page' => 'bail|filled|integer|min:1',
			'count' => 'bail|filled|integer|min:1',
			'lat' => 'bail|required|min:-90|max:90',
			'lng' => 'bail|required|min:-180|max:180',
			'type_id' => 'bail|required|in:0,1,2,3,4,99'
		]);

		$page = $request->input('page', 1);
		$count = $request->input('count', 10);
		$offset = ($page - 1) * $count;
		$lat = $request->input('lat');
		$lng = $request->input('lng');
		$typeId = $request->input('type_id');
		
		if( $typeId == 99 )
		{
			$typeIds = [0,1,2,3,4];
		}
		else
		{
			$typeIds = [$typeId];
		}

		$shops = Shop::whereIn('type_id', $typeIds)
					->skip($offset)
					->take($count)
					->get();

		$distance = '';
		$partner = array();
		$other = array();
		foreach ($shops as $shop) {
			if( !empty($lng) && !empty($lat) )
			{
				$distance = Helper::getDistance($shop->lng, $shop->lat, $lng, $lat).'km';
			}

			if( $shop->is_vip )
			{
				$partner[] = array(
					'id' => $shop->id,
					'name' => $shop->name,
					'image_url' => Config::get('app.ossDomain').$shop->image_url,
					'score' => 4,
					'comments_count' => $shop->comments->count(),
					'type_name' => $this->shopTypes[$shop->cat_id][$shop->type_id],
					'tel' => $shop->tel,
					'distance' => $distance,
					'open_time' => $shop->open_time
				);
			}
			else
			{
				$other[] = array(
					'id' => $shop->id,
					'name' => $shop->name,
					'score' => 4,
					'comments_count' => $shop->comments->count(),
					'type_name' => $this->shopTypes[$shop->cat_id][$shop->type_id],
					'tel' => $shop->tel,
					'distance' => $distance,
					'open_time' => $shop->open_time
				);
			}

		}

		$data = array(
			'shops' => array(
				'partner' => $partner,
				'other' => $other
			),
			'amount' => Shop::whereIn('type_id', $typeIds)->count()
		);

		return $this->successJson( $data );
	}

	/**
	 * @api {get} /shop/show 单个商户详情
	 * @apiName ShopShow
	 * @apiGroup Shop
	 *
	 * @apiParam {Number} shop_id 商户ID
	 * @apiParam {Number} lat
	 * @apiParam {Number} lng
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
		$this->validate($request, [
			'lat' => 'bail|required|min:-90|max:90',
			'lng' => 'bail|required|min:-180|max:180',
			'shop_id' => 'bail|required|exists:shops,id',
		]);

		$lat = $request->input('lat');
		$lng = $request->input('lng');
		$shopId = $request->input('shop_id');
		// $uuid = $request->input('uuid');
		$uuid = $request->header('uuid');
		if( empty($uuid) )
		{
			return $this->failedJson('uuid');
		}

		$shop = Shop::findOrFail( $shopId );
		//添加一条设备访问商户的记录。
		$arr = array(
			'uuid' => $uuid,
			'user_id' => $request->user()->id,
			'client_id' => $request->user()->token()->client_id
		);
		event(new AccessShopEvent($shop, $arr));

		$menu_image_urls = array();
		$tmp = json_decode($shop->menu_image_urls, true);
		foreach ($tmp as $key => $value) {
			if( !empty($value) )
			{
				$menu_image_urls[] = Config::get('app.ossDomain').$value;
			}
		}

		$distance = '';
		if( !empty($lng) && !empty($lat) )
		{
			$distance = Helper::getDistance($shop->lng, $shop->lat, $lng, $lat).'km';
		}

		$data = array(
			'id' => $shop->id,
			'name' => $shop->name,
			'score' => 3,
			'comments_count' => $shop->comments->count(),
			'type_name' => $this->shopTypes[$shop->cat_id][$shop->type_id],
			'tel' => $shop->tel,
			'distance' => $distance,
			'open_time' => $shop->open_time,
			'image_url' => Config::get('app.ossDomain').$shop->image_url,
			'intro' => $shop->intro,
			'addr' => $shop->addr,
			'menu_image_urls' => $menu_image_urls
		);

		return $this->successJson( $data );
	}

	/**
	 * @api {post} /shop/report_error 商户纠错
	 * @apiName ShopHasError
	 * @apiGroup Shop
	 *
	 * @apiParam {Number} err_num 错误号
	 * @apiParam {Number} shop_id
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
		$this->validate($request, [
			'err_num' => 'bail|required|integer|in:1,2,3',
			'shop_id' => 'bail|required|exists:shops,id'
		]);

		$errorNo = $request->input('err_num');
		$shopId = $request->input('shop_id');
		$userId = $request->user()->id;

		DB::table('user_report_shop_errors')->insert([
			'shop_id' => $shopId,
			'user_id' => $userId,
			'err_num' => $errorNo
		]);

		return $this->successJson();
	}

	/**
	 * @api {get} /shop/access_rank_by_month 商户访问数月排行
	 * @apiName ShopAccessRankByMonth
	 * @apiGroup Shop
	 *
	 * @apiParam {Number} [page=1]
	 * @apiParam {Number} [count=10]
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
	public function accessRankByMonth(Request $request)
	{
		$this->validate($request, [
			'page' => 'bail|filled|integer|min:1',
			'count' => 'bail|filled|integer|min:1'
		]);

		$page = $request->input('page', 1);
		$count = $request->input('count', 10);
		$offset = ($page - 1) * $count;

		$accesses = AccessShop::select(DB::raw('count(id) as access_count, shop_id'))
					->where('created_at', '>', Carbon::now()->firstOfMonth())
					->where('created_at', '<', Carbon::now()->lastOfMonth())
					->groupBy('shop_id')
					->orderBy('access_count', 'desc')
					->skip($offset)
					->take($count)
					->get();

		$tmp = array();
		foreach( $accesses AS $access)
		{
			$tmp[] = array(
				'shop' => array(
					'id' => $access->shop->id,
					'tel' => $access->shop->tel,
					'name' => $access->shop->name,
					'image_url' => Config::get('app.ossDomain').$access->shop->image_url
				),
				'count' => $access->access_count
			);
		}

		return $this->successJson( $tmp );
	}
}
