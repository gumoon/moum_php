<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use Config;
use Carbon\Carbon;


class SpreadController extends Controller
{
    /**
     * @api {get} /spread/all APP广告
     * @apiName Spread
     * @apiGroup Spread
     *
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object[]} data APP广告
     * @apiSuccessExample {json} Success-response:
	 * {
	 *  "err_no": 0,
	 *  "msg": "成功",
	 *  "data": {
     * 		"openpage": [
	 *      {
	 *        "image_url": "http://img5.2345.com/toolsimg/baike/collect/sheying/2146599705_650x2000.jpg",
	 *        "url": "http://www.baidu.com/",
	 *        "flag": 0
	 *      },
	 *      {
	 *        "image_url": "http://img1.imgtn.bdimg.com/it/u=1062463557,3581994092&fm=23&gp=0.jpg",
	 *        "shop_id": 10,
	 *        "flag": 1
	 *      }
	 *    ]
	 *  }
	 * }
     * 
     */
	public function all(Request $request)
	{
		$data = array(
			'openpage' => array(
				[
					'image_url' => 'http://img5.2345.com/toolsimg/baike/collect/sheying/2146599705_650x2000.jpg',
					'url' => 'http://www.baidu.com/',
					'flag' => 0
				],
				[
					'image_url' => 'http://img1.imgtn.bdimg.com/it/u=1062463557,3581994092&fm=23&gp=0.jpg',
					'shop_id' => 10,
					'flag' => 1,
				]
			)
		);
		return $this->successJson( $data );
	}	
}
