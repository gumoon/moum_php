<?php

namespace moum\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Log;
use moum\Models\News;

class fetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch {latNum=20 : latest number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓 moum 项目需要的最近多少条新闻';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $logStr = '';
        $latNum = $this->argument('latNum');

        $client = new Client();
        $url1 = "http://www.zoglo.net/stand/getMobileJson/1/board/m_photo_news/0/0/0/{$latNum}/x/0/0/0/0/last_update";
        $url2 = "http://www.zoglo.net/stand/getMobileJson/2/board/media/0/0/0/{$latNum}/m/0/0/0/0/last_update";
        if (mt_rand(1,2) % 2) {
            $url = $url1;
        } else {
            $url = $url2;
        }
        $res = $client->request('get', $url);
        $res = json_decode($res->getBody(), true);
        foreach ($res AS $v) {
            $detailUrl = 'http://www.zoglo.net/stand/getMobileContent/'.$v['doc_id'];
            $resDetail = $client->request('get', $detailUrl);
            $resDetail = json_decode($resDetail->getBody(), true);
            $oldNews = News::where('source', News::NEWS_SOURCE_ZOGLO)
                ->where('doc_id', $v['doc_id'])
                ->first();
            if (empty($oldNews)) {
                $news = new News;
                $news->title = $resDetail[0]['title'];
                $news->content = $resDetail[0]['content'];
                $news->image_url = $v['img1'];
                $news->source = News::NEWS_SOURCE_ZOGLO;
                $news->doc_id = $v['doc_id'];
                $news->public_at = $v['datetime'];

                $news->save();
                $logStr .= $v['doc_id'] . '_';
            }
        }

        if ($logStr) {
            $logStr = date('Y-m-d H:i:s') . '_' . $logStr;
            $this->info($logStr);
        }

    }
}
