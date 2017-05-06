<?php
/**
 * Created by PhpStorm.
 * User: gumoon
 * Date: 2017/5/1
 * Time: 10:02
 */

namespace moum\Http\Controllers\Api;


use moum\Http\Controllers\Controller;
use moum\Notifications\Captcha as CaptchaNotification;

class SmsController extends Controller
{
    /**
     * @api {post} /sms/captcha 获取验证码
     * @apiName SmsCaptcha
     * @apiGroup Sms
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