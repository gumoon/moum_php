<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use Config;
use moum\Models\Spread;
use moum\Models\One14;
use moum\Models\Shop;


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
     * @apiSuccess {Number} [data.can_delivery] 是否是外卖商户
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
	 *        "flag": 1,
     *        "can_delivery": 1
	 *      }
	 *    ]
	 *  }
	 * }
     * 
     */
	public function firing(Request $request)
	{
		$spreads = Spread::where('position_id', 1)
					->orderBy('order', 'desc')
					->get();

		$openpage = array();
		foreach($spreads AS $spread)
		{
			if( $spread->flag == 0 )
			{
				$openpage[] = array(
					'image_url' => $spread->image_url ? Config::get('app.ossDomain'). $spread->image_url : '',
					'url' => $spread->extra,
					'flag' => $spread->flag
				);
			}
			elseif( $spread->flag == 1 )
			{
                $shop = Shop::find($spread->extra);
				$openpage[] = array(
					'image_url' => $spread->image_url ? Config::get('app.ossDomain'). $spread->image_url : '',
					'shop_id' => $spread->extra,
					'flag' => $spread->flag,
                    'can_delivery' => $shop->cat_id == 0 ? 1 : 0,
				);
			}
			
		}

		$data = array(
			'openpage' => $openpage
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
     * @apiSuccess {String} [data.topics.tel]
     * @apiSuccess {Number} data.topics.flag flag=0表示是网页，flag=1表示是商户,flag=2表示是黄页
     * @apiSuccess {Number} [data.can_delivery] 是否是外卖商户
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
	 *        "flag": 1,
     *        "can_delivery":1
	 *      },
	 *      {
	 *        "image_url": "http://image.tupian114.com/20121102/11081330.jpg",
	 *        "url": "http://moum.xiaoyuweb.cn/home/one14/profile/Mg%3D%3D",
	 *        "tel": "18600562137",
	 *        "flag": 2
	 *      }
	 *    ]
	 *  }
	 * }
     * 
	 */
	public function topic(Request $request)
	{
		$spreads = Spread::where('position_id', 2)
					->orderBy('order', 'desc')
					->get();

		$tmp = array();
		foreach($spreads AS $spread)
		{
			if( $spread->flag == 0 )
			{
				$tmp[] = array(
					'image_url' => $spread->image_url ? Config::get('app.ossDomain'). $spread->image_url : '',
					'url' => $spread->extra,
					'flag' => $spread->flag
				);
			}
			elseif( $spread->flag == 1 )
			{
			    $shop = Shop::find($spread->extra);
				$tmp[] = array(
					'image_url' => $spread->image_url ? Config::get('app.ossDomain'). $spread->image_url : '',
					'shop_id' => $spread->extra,
					'flag' => $spread->flag,
                    'can_delivery' => $shop->cat_id == 0 ? 1 : 0,
				);
			}
			elseif( $spread->flag == 2 )
			{
				$one14 = One14::find($spread->extra);
				$tmp[] = array(
					'image_url' => $spread->image_url ? Config::get('app.ossDomain'). $spread->image_url : '',
					'url' => url('home/one14/profile', [base64_encode($spread->extra)]),
					'tel' => $one14->tel,
					'flag' => $spread->flag
				);
			}
			
		}

		$data = array(
			'topics' => $tmp
		);

		return $this->successJson( $data );
	}
}
