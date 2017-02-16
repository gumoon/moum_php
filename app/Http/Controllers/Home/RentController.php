<?php

namespace moum\Http\Controllers\Home;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use moum\Models\Rent;

class RentController extends Controller
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
    public function profile($id)
    {
        $id = base64_decode($id);
        
        $rent = Rent::find($id);

        $houseTypes = collect($this->houseTypes)->keyBy('id');
        $rent['house_type'] = $houseTypes[$rent['house_type_id']]['name'];

        return view('home.rents.profile', ['rent' => $rent]);
    }
}
