<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use moum\Models\User;
use Illuminate\Auth\AuthenticationException;
use Config;
use Hash;
use Notification;
use DB;
use Carbon\Carbon;
use moum\Events\OldUserLogin;
use moum\Notifications\Captcha as CaptchaNotification;

class UserController extends Controller
{
    /**
     * @api {post} /user/login 用户登录
     * @apiName UserLogin
     * @apiGroup User
     * 
     * @apiParam {String} tel 或者email
     * @apiParam {String} password
     * 
     * @apiSuccess {Number} err_no
     * @apiSuccess {String} msg
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.id
     * @apiSuccess {String} data.name
     * @apiSuccess {String} data.profile_image_url
     * @apiSuccess {Number} data.gender
     * @apiSuccess {String} data.tel
     *
     * @apiSuccessExample {json}  Success-response:
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
		$this->validate($request, [
			'tel' => 'required',
			'password' => 'required'
		]);

		$tel = $request->input('tel');
		$password = $request->input('password');

		$user = User::where('tel', $tel)->first();
		//若用户不存在，返回 null
		if( empty($user) )
		{
			//查询是否是 moum 老用户
			$oldUser = DB::table('user_info')
				->where('email', $tel)
				->where('status', 1)
				->first();
			if( empty($oldUser) )
			{
				return $this->failedJson('email or tel');
			}

			//新用户不存在，并且老用户存在
			//判断密码
			if( md5($password) !== $oldUser->password )
			{
				return $this->failedJson('password');
			}

			$gender = $oldUser->gender == 'x' ? 0 : ($oldUser->gender == 'm' ? 1 : 2);
			//往新用户库插入一条记录
			$newUserId = DB::table('users')->insertGetId([
				'name' => $oldUser->name,
				'email' => $oldUser->email,
				'tel' => $oldUser->email,
				'password' => bcrypt($password),
				'gender' => $gender,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);
			//若原用户头像存在的话，同时发送一个事件更新头像
			event(new OldUserLogin($oldUser->profile_image_url, $newUserId));

			$data = array(
				'id' => $newUserId,
				'name' => $oldUser->name ? $oldUser->name : 'MOUM用户',
				'profile_image_url' => $oldUser->profile_image_url ? $oldUser->profile_image_url : 'http://diy.qqjay.com/u2/2012/1002/606b295f562dd328c65448abea1cb2b6.jpg',
				'gender' => $gender,
				'tel' => $tel
			);
		}
		else
		{
			//新用户存在
			//判断密码是否正确
			if( !Hash::check($password, $user->password) )
			{
				return $this->failedJson('password');
			}

			$data = array(
				'id' => $user->id,
				'name' => $user->name ? $user->name : 'MOUM用户',
				'profile_image_url' => $user->profile_image_url ? Config::get('app.ossDomain').$user->profile_image_url : 'http://diy.qqjay.com/u2/2012/1002/606b295f562dd328c65448abea1cb2b6.jpg',
				'gender' => $user->gender,
				'tel' => $user->tel
			);			
		}

		return $this->successJson($data);
	}

	/**
	 * @api {post} /user/register 用户注册
	 * @apiName UserRegister
	 * @apiGroup User
	 *
	 * @apiParam {String} tel
	 * @apiParam {String} captcha
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
		$this->validate($request, [
			'tel' => 'bail|required|unique:users',
			'password' => 'bail|required',
			'captcha' => 'bail|required'
		]);

		$tel = $request->input('tel');
		$password = $request->input('password');
		$captcha = $request->input('captcha');

		$saved = User::create([
            'email' => $tel,
            'password' => bcrypt($password),
            'tel' => $tel
        ]);

		$data = array(
			'id' => $saved->id,
			'name' => 'MOUM用户',
			'profile_image_url' => 'http://diy.qqjay.com/u2/2012/1002/606b295f562dd328c65448abea1cb2b6.jpg',
			'gender' => 0,
			'tel' => $tel
		);

		return $this->successJson($data);
	}

	/**
	 * @api {post} /user/update 用户数据更新
	 * @apiName UserUpdate
	 * @apiGroup User
	 *
	 * @apiParam {String} name
	 * @apiParam {String} profile_image_url
	 * @apiParam {Number} gender
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
	public function update(Request $request)
	{
		$this->validate($request, [
			'name' => 'bail|filled|max:100',
			'profile_image_url' => 'bail|filled|max:255',
			'gender' => 'bail|filled|integer|in:0,1,2',
		]);

		$name = $request->input('name');
		$profile_image_url = $request->input('profile_image_url');
		$gender = $request->input('gender');

		$user = User::find($request->user()->id);
		if( !empty($name) )
		{
			$user->name = $name;
		}
		if( !empty($profile_image_url) )
		{
			$user->profile_image_url = $profile_image_url;
		}
		if( !empty($gender) )
		{
			$user->gender = $gender;
		}

		$user->save();

		$data = array(
			'id' => $request->user()->id,
			'name' => $name ? $name : ($user->name ? $this->name : 'MOUM用户'),
			'profile_image_url' => $profile_image_url ? Config::get('app.ossDomain').$profile_image_url : ($user->profile_image_url ? Config::get('app.ossDomain').$user->profile_image_url : 'http://diy.qqjay.com/u2/2012/1002/606b295f562dd328c65448abea1cb2b6.jpg'),
			'gender' => $gender ? $gender : $user->gender,
			'tel' => $user->tel
		);

		return $this->successJson($data);
	}

	/**
	 * @api {post} /user/reset_password 重置密码
	 * @apiName UserResetPassword
	 * @apiGroup User
	 *
	 * @apiParam {String} tel
	 * @apiParam {String} password
	 * @apiParam {Number} captcha
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
		$this->validate($request, [
			'tel' => 'bail|required|exists:users,tel',
			'password' => 'bail|required',
			'captcha' => 'bail|required'
		]);

		$tel = $request->input('tel');
		$password = $request->input('password');
		$captcha = $request->input('captcha');

		$userFind = User::where('tel', $tel)->first();

		$user = User::find($userFind->id);
		$user->password = bcrypt($password);
		$user->save();

		return $this->successJson();
	}

    /**
     * @api {post} /user/captcha 获取验证码
     * @apiName UserCaptcha
     * @apiGroup User
     *
     * @apiParam {String} tel
     *
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
     *    "captcha": "123456"
     *  }
     * }
     */
    public function captcha(Request $request)
    {
        $this->validate($request, [
            'tel' => 'required'
        ]);

        $tel = $request->input('tel');

        $captcha = mt_rand(100000, 999999);

        $tmp = array(
            'tel' => $tel,
            'captcha' => $captcha
        );

        //发短信验证码给用户
        Notification::send($request->user(), new CaptchaNotification($tmp));

        $data = array(
            'captcha' => $captcha
        );
        return $this->successJson($data);
    }
}
