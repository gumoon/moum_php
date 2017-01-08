<?php

namespace moum\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Carbon\Carbon;
use Pusher;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return redirect('/houtai');
        return view('home');
    }

    public function phpinfo()
    {
        phpinfo();
    }

    public function debug()
    {
        Carbon::setLocale('zh');
        echo Carbon::now()->subSeconds(5)->diffForHumans();
        echo Carbon::now();
    }

    public function push()
    {
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );
        $pusher = new Pusher(
            '97231a690082735858b8',
            'bf78bb9883986199c250',
            '287630',
            $options
        );

        $data['message'] = 'hello world';
        $pusher->trigger('my-channel', 'my-event', $data); 
    }

    public function pusher()
    {
        return view('pusher');
    }
}
