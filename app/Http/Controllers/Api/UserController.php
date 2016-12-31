<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;


class UserController extends Controller
{
    /**
     * @api {post} /user/login 用户登录
     * @apiName UserLogin
     * @apiGroup User
     * 
     *
     * @apiSuccess {int} err_no
     * @apiSuccess {string} msg
     * @apiSuccess {object} data
     * @apiSuccess {Number} data.id
     * @apiSuccess {String} data.name
     * @apiSuccess {String} data.profile_image_url
     * @apiSuccess {Number} data.gender
     * @apiSuccess {String} data.tel
     *
     * @apiSuccess {json} Success-response:
     * {
	 *  "err_no": 0,
	 *  "msg": "success",
	 *  "data": {
	 *    "id": 1,
	 *    "name": "moon",
	 *    "profile_image_url": "http://diy.qqjay.com/u2/2012/1002/606b295f562dd328c65448abea1cb2b6.jpg",
	 *    "gender": 1,
	 *    "tel": "18600562137"
	 *  }
	 * }
     */
	public function login(Request $request)
	{
		$user = array(
			'id' => 1,
			'name' => 'moon',
			'profile_image_url' => 'http://diy.qqjay.com/u2/2012/1002/606b295f562dd328c65448abea1cb2b6.jpg',
			'gender' => 1,
			'tel' => '18600562137'
		);

		return $this->successJson($user);
	}
}
