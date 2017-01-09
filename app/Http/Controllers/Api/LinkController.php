<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use moum\Models\Link;
use Config;


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
	public function all()
	{
		$links = Link::all();

		$china = array();
		$korea = array();
		foreach($links AS $link)
		{
			if($link->nation_id == 0)
			{
				$china[] = array(
					'icon' => Config::get('app.ossDomain').$link->icon,
					'name' => $link->name,
					'url' => $link->url
				);
			}
			else
			{
				$korea[] = array(
					'icon' => Config::get('app.ossDomain').$link->icon,
					'name' => $link->name,
					'url' => $link->url
				);				
			}
		}
		
		$links = array(
			'china' => $china,
			'korea' => $korea
		);

		return $this->successJson( $links );
	}
}
