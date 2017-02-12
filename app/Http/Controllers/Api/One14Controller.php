<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use Config;
use moum\Models\One14;

class One14Controller extends Controller
{
	/**
	 * @api {get} /one14/categorize 114黄页分类（大分类、子分类）
	 * 
	 * @apiName One14Categorize
	 * @apiGroup One14
	 *
	 * 
	 * @apiSuccess {Number} err_no 
	 * @apiSuccess {String} msg
	 * @apiSuccess {Object} data
	 * 
	 */
	public function categorize(Request $request)
	{
		return $this->successJson($this->one14Categories);
	}

	/**
	 * @api {get} /one14/arround 周边黄页商户列表
	 * @apiName One14Arround
	 * @apiGroup One14
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
	 * @apiSuccess {String} data.partner.tel 商户电话
	 * @apiSuccess {Number} data.partner.tags 标签列表,用半角分号分隔
	 * @apiSuccess {String} data.partner.addr 地址
	 * @apiSuccess {Object[]} data.other
	 * @apiSuccess {Number} data.other.id 商户ID
	 * @apiSuccess {String} data.other.name 商户名
	 * @apiSuccess {String} data.other.tel 商户电话
	 * @apiSuccess {Number} data.amount 满足条件的商户总数
	 *
	 * @apiSuccessExample {json} Success-response:
	 * {
	 *  "err_no": 0,
	 *  "msg": "成功",
	 *  "data": {
	 *    "one14": {
	 *      "partner": [
	 *        {
	 *        	"id": 1,
	 *          "name": "韩国驻北京领事馆",
	 *          "image_url": "http://www.idaocao.com/daocaoeditor/uploadfile/2008815124937986.jpg",
	 *          "tel": "18600562137",
	 *          "tags": "标签1;标签2",
	 *          "addr": "朝阳区望京SOHO23-234-3",
	 *          "url": "http://www.baidu.com/"
	 *        }
	 *      ],
	 *      "other": [
	 *        {
	 *        	"id": 1,
	 *          "name": "某某KTV",
	 *          "tel": "13911112222"
	 *        }
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
			'type_id' => 'bail|required'
		]);

		$page = $request->input('page', 1);
		$count = $request->input('count', 10);
		$offset = ($page - 1) * $count;
		$lat = $request->input('lat');
		$lng = $request->input('lng');
		$typeId = $request->input('type_id');

		$one14s = One14::where('type_id', $typeId)
					->skip($offset)
					->take($count)
					->get();

		$partner = array();
		$other = array();
		foreach( $one14s AS $one14 )
		{
			if( $one14->is_vip == 1 )
			{
				$partner[] = array(
					'id' => $one14->id,
					'name' => $one14->name,
					'image_url' => $one14->image_url ? Config::get('app.ossDomain').$one14->image_url : '',
					'tel' => $one14->tel,
					'tags' => $one14->tags,
					'addr' => $one14->addr,
					'url' => 'http://www.baidu.com/'
				);
			}
			else
			{
				$other[] = array(
					'id' => $one14->id,
					'name' => $one14->name,
					'tel' => $one14->tel
				);
			}
		}

		$data = array(
			'one14' => array(
				'partner' => $partner,
				'other' => $other
			),
			'amount' => One14::where('type_id', $typeId)->count()
		);

		return $this->successJson( $data );
	}
}
