<?php

namespace moum\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Carbon\Carbon;

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
}
