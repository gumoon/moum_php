<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;


class CommonController extends Controller
{
    /**
     * @api {post} /common/init 进入APP时调用
     * @apiName CommonInit
     * @apiGroup Common
     * 
     * @apiParam  {string} uuid 设备标识符
     * @apiSuccess {int} err_no
     * @apiSuccess {string} msg
     * @apiSuccess {object} data
     */
	public function init(Request $request)
	{
		//设备唯一标识符
		$uuid = $request->input('uuid');

		return $this->successJson();
	}

	/**
	 * @api {post} /oauth/token 获取access_token
	 * @apiName OauthToken
	 * @apiGroup Auth
	 *
	 * @apiParam {String} grant_type
	 * @apiParam {Number} clint_id
	 * @apiParam {String} client_secret
	 * @apiParam {String} username
	 * @apiParam {String} password
	 *
	 * @apiSuccess {String} token_type token 类型
	 * @apiSuccess {Number} expires_in 过期期限
	 * @apiSuccess {String} access_token 访问token
	 * @apiSuccess {String} refresh_token 刷新token
	 *
	 * @apiSuccessExample {json} Success-Response:
	 * {
	 *  "token_type": "Bearer",
  	 *	"expires_in": 86400,
	 *  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijk0MzI2OTZmYjc4NmUxYWRlNDBjMGMzODY2ZWZlOTQ2ZTBiOWM1MmYzNDQ1NjYxYWZiYTg4ZGQxNGYxNDVlNDk4YzUwN2M2ZDliZjMwYmE0In0.eyJhdWQiOiIyIiwianRpIjoiOTQzMjY5NmZiNzg2ZTFhZGU0MGMwYzM4NjZlZmU5NDZlMGI5YzUyZjM0NDU2NjFhZmJhODhkZDE0ZjE0NWU0OThjNTA3YzZkOWJmMzBiYTQiLCJpYXQiOjE0ODI2NDk5MTAsIm5iZiI6MTQ4MjY0OTkxMCwiZXhwIjoxNDgyNzM2MzEwLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.ZsJLbt6I5fyuQicuARcP6UXGWbmmJ_7Cue9yoC5W5W-s7LwYx6aPbFO-RacME7Ls8UOvw59mrUK8W7O8eRDFdjblerjKh4YE8qIvaDOXFCwdNVTY9Z4MK0U523nk_sZdPKUBzbn9PkqsUHrnIsPtaZkf4lmctJy9C0fUPZRc-lDFTSTCgtQtbvNKxJQlNkZT2gbzBoct2aopuD9G4HJXAyYAJwUQ3vDoxleKymUjEzSLN7GudmbX2MbGBhSEisxVwYy0LWfh4Mz8PdknxWxklD9rJN8Y6gjyudFmuk2_3q4WvF_sCLoTOY0_QI_m_IIbpjvR8aqLCzWQ5N3tqFbbM-IrL0ahE1HWbql2kxvGOS-i9jRrKLhUp89Y9rwAFdtJ5YSVl9NbZy5RV_CzjBECNKaThUCM1NwWh6d-t-kgzMQF_iiFLEfrBpjhumg344F9D4FkD5tROAWkAmVr-JGPmRMx9OPvyUaK9HuNEnlDmzdkTJRMjRy_lpR4l5sf2iPph36UdLx7LqWZI7kuVNlM2Y17LpIiODcG5b8-XCT680Q7Pr5l5Gy2qfLtrNRGA4lSXKsiTiHpxGqntsoEHYcgumvE2iZGxUQHmhErIgHbIuEZwZIvbIWkej7bnjYlp2VJ4rPfkxUA0EyqNobl7a_8sh1b5i3Xyv6VFJMs07v_YOY",
	 *  "refresh_token": "YR0/nNB0uoawjxIP5s4JmhEJunVkXW/CNQEaE/Qr9fsB6eHisma0nXg5PhNqNq9Xr4YHfiwsj/23FKrwLH5RGqF/gXSiIDQbbKCAO+VyBhD1l5P3ggookpcmQ/G04Ls/+DxjXotJ2NTasIKgONTxvA0vVqiuLNCHaFPWflRrsfDjZFW8WJTZW0WXacku3QjQBVBo+zEvNQbRTWKtaS5fNxIKRQAHoG9c4CQfDu/QoRa1ZDd2OuPUY0VWaZm8wVDVFRenhJQND7QWXzXXaLQZ+/eaPFRHEX+r95QLTEPkieHgoyc7qbhyXWc4/OBfLMKwIUpFVYeT4TgFBMl2a8f/Hu+8RUUX/aH3Ef9jk6hteHzg12MhAXWNGkUi/+wiP4wfet50BbRPWSQQ0lOks5v5Uk/kuZjv8yKUx8R8VMuHs3nwg8GVW194zk5sKLx5RJXnlBmVnjABClLXZOZV7iHtvC2LRjlYQQXh3QPApgAbuxSWayMoSvzActNGFOAV4RE3H27sND3rr/RK6cyFlvGjWqM9+9eumwCfLYrHA5OG6o68FuZsD2K7vRFckaGebp9zp0rVhFZRhG9CSaO/jmAqPUStr74hNFkzsx+A6fbyry/91jeQN8pWiSSZEjuS3B56AVwk+Csl4i72uimuDpfh9ds5+Pk91EmTcnOrGsGrwWI="
	 * }
	 */
}
