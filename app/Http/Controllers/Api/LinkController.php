<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;


class LinkController extends Controller
{
    /**
     * @api {get} /discover/links 发现模块的常用链接
     * @apiName DiscoverLinks
     * @apiGroup Discover
     *
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object} data
     * @apiSuccess {Object[]} data.china 中国常用网址
     * @apiSuccess {String} data.china.icon 网址icon
     * @apiSuccess {String} data.china.name 网址名称
     * @apiSuccess {String} data.china.url 网址
     * @apiSuccess {Object[]} data.korea 韩国常用网址
     * @apiSuccess {String} data.korea.icon 网址icon
     * @apiSuccess {String} data.korea.name 网址名称
     * @apiSuccess {String} data.korea.url 网址
     *
     * @apiSuccessExample {json} Success-response:
     * {
	 *  "err_no": 0,
	 *  "msg": "success",
	 *  "data": {
	 *    "china": [
	 *      {
	 *        "icon": "http://sr.photos3.fotosearch.com/bthumb/CSP/CSP433/k4337069.jpg",
	 *        "name": "百度",
	 *        "url": "http://www.baidu.com"
	 *      }
	 *      ...
	 *    ],
	 *    "korea": [
	 *      {
	 *        "icon": "http://sr.photos3.fotosearch.com/bthumb/CSP/CSP433/k4337069.jpg",
	 *        "name": "新浪",
	 *        "url": "http://www.sina.com.cn"
	 *      }
	 *      ...
	 *    ]
	 *  }
	 * }
     * 
     */
	public function all(Request $request)
	{
		for ($i=0; $i < 10; $i++) 
		{ 
			$tmp1[] = array(
				'icon' => 'http://sr.photos3.fotosearch.com/bthumb/CSP/CSP433/k4337069.jpg',
				'name' => '百度',
				'url' => 'http://www.baidu.com'
			);
		}

		for ($i=0; $i < 10; $i++) 
		{ 
			$tmp2[] = array(
				'icon' => 'http://a.hiphotos.baidu.com/zhidao/wh%3D450%2C600/sign=b287ba24be096b63814c56543903ab72/b64543a98226cffca6d6c2b9b9014a90f603ea39.jpg',
				'name' => '新浪',
				'url' => 'http://www.sina.com.cn'
			);
		}
		
		$links = array(
			'china' => $tmp1,
			'korea' => $tmp2
		);

		return $this->successJson( $links );
	}
}
