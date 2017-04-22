<?php

namespace moum\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Log;

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
        $latNum = $this->argument('latNum');

        $client = new Client();
        $url = "http://www.zoglo.net/stand/getMobileJson/1/board/m_photo_news/0/0/0/{$latNum}/x/0/0/0/0/last_update";
        $url = "http://www.zoglo.net/board/read/m_photo_news/308167";
        $res = $client->request('get', $url);
        Log::info($res->getBody());


        $this->info($res->getBody());
    }
}
