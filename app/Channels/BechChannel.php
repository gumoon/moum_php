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
        $client = new Client();
        $url = 'https://imlaixin.cn/Api/send/data/json';
        $tmp = array(
            'accesskey' => '2096',
            'secretkey' => 'b0087796c740e94ea1bc5dddacde5cb31809d8e5',
            'mobile' => '18600562137',
            'content' => urlencode('短信验证码：123456【对话世界】')
        );

        $res = $client->request('get', $url, ['query' => $tmp]);
        Log::info($res->getBody());
    }
}