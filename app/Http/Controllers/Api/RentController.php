<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Models\Rent;
use moum\Http\Controllers\Controller;
use moum\Services\Helper;
use Config;

class RentController extends Controller
{
	/**
	 * @api {get} /rent/arround 附近的租房列表
	 * 
	 * @apiName RentArround
	 * @apiGroup Rent
	 *
	 * @apiParam {Number} lat
	 * @apiParam {Number} lng
	 * @apiParam {Number} [page=1]
	 * @apiParam {Number} [count=10]
	 * 
	 * @apiSuccess {Number} err_no 
	 * @apiSuccess {String} msg
	 * @apiSuccess {Object} data
	 * @apiSuccessExample {json} Success-response: 
	 * {
	 *  "err_no": 0,
	 *  "msg": "成功",
	 *  "data": {
	 *    "houses": [
	 *      {
	 *        "id": 0,
	 *        "title": "全城最低价,短租月付",
	 *        "image_url": "http://yun.qfangimg.com/group1/1000x1000/M00/CF/8A/CvtcNFdvYI-AT5-CAADaia6oOcE506.jpg",
	 *        "distance": "2.4km",
	 *        "type_name": "一室一厅一厨一卫",
	 *        "price": "2400元/月",
	 *        "addr": "海淀区五道口清华大学附近小区19-12-3",
	 *        "url": "http://www.baidu.com/"
	 *      }
	 *    ],
	 *    "amount": 30
	 *  }
	 * }
	 */
	public function arround(Request $request)
	{
		$this->validate($request, [
			'lat' => 'bail|required|min:-90|max:90',
			'lng' => 'bail|required|min:-180|max:180',
			'page' => 'bail|filled|integer|min:1',
			'count' => 'bail|filled|integer|min:1'
		]);

		$lat = $request->input('lat');
		$lng = $request->input('lng');
		$page = $request->input('page', 1);
		$count = $request->input('count', 10);
		$offset = ($page - 1) * $count;

		$rents = Rent::where('id', '>', 0)
					->skip($offset)
					->take($count)
					->get();
		
		$tmp = array();
		$distance = '';
		foreach($rents AS $rent)
		{
			if( !empty($lng) && !empty($lat) )
			{
				$distance = Helper::getDistance($shop->lng, $shop->lat, $lng, $lat).'km';
			}

			$tmp[] = array(
				'id' => $rent->id,
				'title' => $rent->title,
				'image_url' => $rent->image_url ? Config::get('app.ossDomain').$rent->image_url : '',
				'distance' => $distance,
				'price' => $rent->price.'元/月',
				'addr' => $rent->addr,
				'url' => 'http://www.baidu.com/'
			);
		}

		$data = array(
			'houses' => $tmp,
			'amount' => Rent::where('id', '>', 0)->count()
		);

		return $this->successJson( $data );
	}
	
}
