<?php

namespace moum\Http\Controllers\Home;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use moum\Models\One14;

class One14Controller extends Controller
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

    public function profile($id)
    {
        $id = base64_decode($id);
        
        $one14 = One14::find($id);

        return view('home.one14s.profile', ['one14' => $one14]);
    }
}
