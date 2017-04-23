<?php

namespace moum\Http\Controllers\Home;

use moum\Http\Controllers\Controller;
use moum\Models\News;

class NewsController extends Controller
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
    public function detail($id)
    {
        $id = base64_decode($id);
        
        $news = News::find($id);

        return view('home.news.detail', ['news' => $news]);
    }
}
