<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use Config;
use Carbon\Carbon;


class SpreadController extends Controller
{
    /**
     * @api {get} /spread/firing APP启动页广告
     * @apiName SpreadFiring
     * @apiGroup Spread
     *
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object} data APP启动页广告
     * @apiSuccess {Object[]} data.openpage
     * @apiSuccess {String} data.openpage.image_url
     * @apiSuccess {String} [data.openpage.url]
     * @apiSuccess {Number} [data.openpage.shop_id]
     * @apiSuccess {Number} data.openpage.flag flag=0表示是网页，flag=1表示是商户
     * 
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
	public function firing(Request $request)
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

	/**
	 * @api {get} /spread/topic APP首页的主题列表
	 * @apiName SpreadTopic
	 * @apiGroup Spread
	 *
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object[]} data APP首页主题列表
     * @apiSuccess {Object[]} data.topics
     * @apiSuccess {String} data.topics.image_url
     * @apiSuccess {String} [data.topics.url]
     * @apiSuccess {Number} [data.topics.shop_id]
     * @apiSuccess {Number} data.topics.flag flag=0表示是网页，flag=1表示是商户,flag=2表示是黄页
     * 
     * @apiSuccessExample {json} Success-response:
     * {
	 *  "err_no": 0,
	 *  "msg": "成功",
	 *  "data": {
	 *    "topics": [
	 *      {
	 *        "image_url": "http://img5.2345.com/toolsimg/baike/collect/sheying/2146599705_650x2000.jpg",
	 *        "url": "http://www.baidu.com/",
	 *        "flag": 0
	 *      },
	 *      {
	 *        "image_url": "http://img1.imgtn.bdimg.com/it/u=1062463557,3581994092&fm=23&gp=0.jpg",
	 *        "shop_id": 10,
	 *        "flag": 1
	 *      },
	 *      {
	 *        "image_url": "http://image.tupian114.com/20121102/11081330.jpg",
	 *        "url": "http://moum.xiaoyuweb.cn/home/one14/profile/Mg%3D%3D",
	 *        "id": 1,
	 *        "flag": 2
	 *      }
	 *    ]
	 *  }
	 * }
     * 
	 */
	public function topic(Request $request)
	{
		$data = array(
			'topics' => array(
				array(
					'image_url' => 'http://img5.2345.com/toolsimg/baike/collect/sheying/2146599705_650x2000.jpg',
					'url' => 'http://www.baidu.com/',
					'flag' => 0
				),
				array(
					'image_url' => 'http://img1.imgtn.bdimg.com/it/u=1062463557,3581994092&fm=23&gp=0.jpg',
					'shop_id' => 10,
					'flag' => 1
				),
				array(
					'image_url' => 'http://image.tupian114.com/20121102/11081330.jpg',
					'url' => 'http://moum.xiaoyuweb.cn/home/one14/profile/Mg%3D%3D',
					'id' => 1,
					'flag' => 2
				)
			)
		);
		
		return $this->successJson( $data );
	}
}
