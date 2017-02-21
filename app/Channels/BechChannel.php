<?php

namespace moum\Channels;

use Illuminate\Notifications\Notification;
use Log;
use GuzzleHttp\Client;

class BechChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        //$notifiable 是可被通知的对象

        Log::info('bechsms send: '.$notification->data['captcha']);
        $content = "【Moum】短信验证码：".$notification->data['captcha']." ，该验证码将用于注册/修改密码，并于5分钟后失效，请尽快使用。";
        $client = new Client();
        $url = 'https://imlaixin.cn/Api/send/data/json';
        $tmp = array(
            'accesskey' => '2096',
            'secretkey' => 'b0087796c740e94ea1bc5dddacde5cb31809d8e5',
            'mobile' => $notification->data['tel'],
            'content' => urlencode($content)
        );

        $res = $client->request('get', $url, ['query' => $tmp]);
        Log::info($res->getBody());
    }
}