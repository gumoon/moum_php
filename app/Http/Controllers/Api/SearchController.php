<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Models\Shop;
use moum\Models\One14;
use Config;
use moum\Services\Helper;
use moum\Http\Controllers\Controller;

class SearchController extends Controller
{
	//分别从每个表读取几条记录
	const TAKE_DEFAULT_COUNT = 50;

	/**
	 * @api {get} /search/shop 商户搜索
	 * @apiName SearchShop
	 * @apiGroup Search
	 *
	 * @apiParam {String} keyword 查询关键字
	 * @apiParam {Number} [page=1]
	 * @apiParam {Number} [count=10]
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
	 * 
	 */
	public function shop(Request $request)
	{
		$this->validate($request, [
			'keyword' => 'bail|required|max:255',
			'page' => 'bail|filled|integer|min:1',
			'count' => 'bail|filled|integer|min:1',
			'lat' => 'bail|required|min:-90|max:90',
			'lng' => 'bail|required|min:-180|max:180'
		]);

		$keyword = $request->input('keyword');
		$page = $request->input('page', 1);
		$count = $request->input('count', 10);
		$offset = ($page - 1) * $count;
		$lat = $request->input('lat');
		$lng = $request->input('lng');

		$shops = Shop::where('name', 'like', '%'.$keyword.'%')
					->skip($offset)
					->take($count)
					->get();

		$tmp = array();
		foreach ($shops as $shop) 
		{
			$distance = '';
			if( !empty($lng) && !empty($lat) )
			{
				$distance = Helper::getDistance($shop->lng, $shop->lat, $lng, $lat).'km';
			}

			$tmp[] = array(
				'id' => $shop->id,
				'name' => $shop->name,
				'image_url' => $shop->image_url ? Config::get('app.ossDomain').$shop->image_url : '',
				'score' => 4,
				'comments_count' => $shop->comments->count(),
				'type_name' => $this->shopTypes[$shop->cat_id][$shop->type_id],
				'tel' => $shop->tel,
				'distance' => $distance,
				'open_time' => $shop->open_time,
				'is_vip' => $shop->is_vip
			);
		}

		$data = array(
			'shops' => $tmp,
			'amount' => $shops->count()
		);

		return $this->successJson( $data );
	}

	/**
	 * @api {get} /shop/global 全局搜索
	 * @apiName SearchGlobal
	 * @apiGroup Search
	 *
	 * @apiParam {String} keyword 查询关键字
	 * @apiParam {Number} [page=1]
	 * @apiParam {Number} [count=10]
	 * @apiParam {Number} lat
	 * @apiParam {Number} lng
	 * 
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object} data 
     * @apiSuccess {Object[]} data.result 结果列表
     * @apiSuccess {Number} data.result.flag 0=外卖商户，1=黄页信息
     * @apiSuccess {Number} data.result.id ID
     * @apiSuccess {String} data.result.name 名称
     * @apiSuccess {String} [data.result.image_url] 商户头图
     * @apiSuccess {Number} [data.result.score] 评星
     * @apiSuccess {Number} [data.result.coumments_count] 评论数
     * @apiSuccess {String} [data.result.type_name] 子类名
     * @apiSuccess {String} data.result.tel 电话号
     * @apiSuccess {Number} [data.result.distance] 距离
     * @apiSuccess {String} [data.result.open_time] 营业时间
     * @apiSuccess {Number} data.amount 满足条件的记录总数
	 *
	 * @apiSuccessExample {json} Success-response:
	 * {
	 *   "err_no": 0,
	 *   "msg": "成功",
	 *   "data": {
	 *     "result": [
	 *       {
	 *         "id": 4,
	 *         "name": "111",
	 *         "image_url": "",
	 *         "score": 4,
	 *         "comments_count": 0,
	 *         "type_name": "도시락.중식.죽",
	 *         "tel": "18600562137",
	 *         "distance": "",
	 *         "open_time": "1111777",
	 *         "is_vip": 1,
	 *         "flag": 0
	 *       },
	 *       {
	 *         "id": 1,
	 *         "name": "111",
	 *         "tel": "ddd",
	 *         "is_vip": 1,
	 *         "image_url": "",
	 *         "addr": "",
	 *         "tags": "",
	 *         "flag": 1
	 *       }
	 *     ],
	 *     "amount": 2
	 *   }
	 * }
	 * 
	 */
	public function global(Request $request)
	{
		$this->validate($request, [
			'keyword' => 'bail|required|max:255',
			'page' => 'bail|filled|integer|min:1',
			'count' => 'bail|filled|integer|min:1',
			'lat' => 'bail|required|min:-90|max:90',
			'lng' => 'bail|required|min:-180|max:180'
		]);

		$keyword = $request->input('keyword');
		$page = $request->input('page', 1);
		$count = $request->input('count', 10);
		$offset = ($page - 1) * $count;
		$lat = $request->input('lat');
		$lng = $request->input('lng');

		$shops = Shop::where('name', 'like', '%'.$keyword.'%')
					->take(self::TAKE_DEFAULT_COUNT)
					->get();

		$tmp = array();
		foreach ($shops as $shop) 
		{
			$distance = '';
			if( !empty($lng) && !empty($lat) )
			{
				$distance = Helper::getDistance($shop->lng, $shop->lat, $lng, $lat).'km';
			}

			$tmp[] = array(
				'id' => $shop->id,
				'name' => $shop->name,
				'image_url' => $shop->image_url ? Config::get('app.ossDomain').$shop->image_url : '',
				'score' => 4,
				'comments_count' => $shop->comments->count(),
				'type_name' => $this->shopTypes[$shop->cat_id][$shop->type_id],
				'tel' => $shop->tel,
				'distance' => $distance,
				'open_time' => $shop->open_time,
				'is_vip' => $shop->is_vip,
				'flag' => 0
			);
		}

		$one14s = One14::where('name', 'like', '%'.$keyword.'%')
					->take(self::TAKE_DEFAULT_COUNT)
					->get();

		foreach ($one14s as $one14) 
		{
			$tmp[] = array(
				'id' => $one14->id,
				'name' => $one14->name,
				'tel' => $one14->tel,
				'is_vip' => $one14->is_vip,
				'image_url' => $one14->image_url ? Config::get('app.ossDomain').$one14->image_url : '',
				'tags' => $one14->tags,
				'addr' => $one14->addr,
				'url' => url('home/one14/profile', [base64_encode($one14->id)]),
				'flag' => 1,
			);
		}


		$data = array(
			'result' => array_slice($tmp, $offset, $count),
			'amount' => count($tmp)
		);

		return $this->successJson( $data );
	}
}
