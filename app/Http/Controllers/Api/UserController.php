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

	/**
	 * @api {post} /user/register 用户注册
	 * @apiName UserRegister
	 * @apiGroup User
	 *
	 * @apiParam {String} tel
	 * @apiParam {String} captcha
	 * @apiParam {String} email
	 * @apiParam {String} password
	 * 
	 * @apiSuccess {Number} err_no
	 * @apiSuccess {String} msg
	 * @apiSuccess {Object} data
	 *
	 * @apiSuccessExample {json} Success-response:
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
	 * 
	 */
	public function register(Request $request)
	{
		$tel = $request->input('tel');
		$password = $request->input('password');

		$user = array(
			'id' => 1,
			'name' => 'moon',
			'profile_image_url' => 'http://diy.qqjay.com/u2/2012/1002/606b295f562dd328c65448abea1cb2b6.jpg',
			'gender' => 1,
			'tel' => '18600562137'
		);

		return $this->successJson($user);
	}

	/**
	 * @api {post} /user/update 用户数据更新
	 * @apiName UserUpdate
	 * @apiGroup User
	 *
	 * @apiParam {String} tel
	 * @apiParam {String} password
	 *
	 * @apiSuccess {Number} err_no
	 * @apiSuccess {String} msg
	 * @apiSuccess {Object} data
	 *
	 * @apiSuccessExample {json} Success-response:
	 * {
	 *  "err_no": 0,
	 *  "msg": "success",
	 *  "data": {}
	 * }
	 * 
	 */
	public function update(Request $request)
	{
		return $this->successJson();
	}

	/**
	 * @api {post} /user/reset_password 重置密码
	 * @apiName UserResetPassword
	 * @apiGroup User
	 *
	 * @apiParam {String} tel
	 * @apiParam {String} password
	 *
	 * @apiSuccess {Number} err_no
	 * @apiSuccess {String} msg
	 * @apiSuccess {Object} data
	 *
	 * @apiSuccessExample {json} Success-response:
	 * {
	 *  "err_no": 0,
	 *  "msg": "success",
	 *  "data": {}
	 * }
	 */
	public function resetPassword(Request $request)
	{
		return $this->successJson();
	}

	/**
	 * @api {post} /user/captcha 获取验证码
	 * @apiName UserCaptcha
	 * @apiGroup User
	 *
	 * @apiParam {String} tel
	 * @apiSuccess {Number} err_no
	 * @apiSuccess {String} msg
	 * @apiSuccess {Object} data
	 * @apiSuccess {String} data.captcha
	 *
	 * @apiSuccessExample {json} Success-response:
	 * {
	 *  "err_no": 0,
	 *  "msg": "success",
	 *  "data": {
	 *    "captcha": "12d456"
	 *  }
	 * }
	 */
	public function captcha(Request $request)
	{
		$code = '1234';
		$data = array(
			'captcha' => '12d456'
		);

		return $this->successJson($data);
	}
}
