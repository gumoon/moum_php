<?php

namespace moum\Http\Controllers\Admin;

use Illuminate\Http\Request;
use moum\Http\Requests\StoreShopPost;
use moum\Models\Shop;
use moum\Models\Rent;
use Config;
use moum\Http\Controllers\Controller;


class SpreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rents = Rent::all();

        return view('admin.rents.index', ['rents' => $rents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rents.create', [
            'houseTypes' => $this->houseTypes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rent = new Rent;
        $rent->title = $request->input('title');
        $rent->image_url = $request->input('image_url');
        $rent->house_type_id = $request->input('house_type_id');
        $rent->tel = $request->input('tel');
        $rent->lat = $request->input('lat');
        $rent->lng = $request->input('lng');
        $rent->addr = $request->input('addr');
        $rent->is_rented = $request->input('is_rented');
        $rent->detail = $request->input('detail');
        $rent->price = $request->input('price');

        $rent->save();
 
        if( $request->expectsJson() )
        {
            return $this->successJson();
        }
        else
        {
            return redirect('/houtai/rents');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = intval($id);

        $rent = Rent::findOrFail($id);

        //头图
        $rent->image_url_src = empty($rent->image_url) ? '' : Config::get('app.ossDomain'). $rent->image_url;

        return view('admin.rents.edit', ['rent' => $rent, 'houseTypes' => $this->houseTypes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = intval($id);

        $rent = Rent::find($id);
        $rent->title = $request->input('title');
        $rent->image_url = $request->input('image_url');
        $rent->house_type_id = $request->input('house_type_id');
        $rent->tel = $request->input('tel');
        $rent->lat = $request->input('lat');
        $rent->lng = $request->input('lng');
        $rent->addr = $request->input('addr');
        $rent->is_rented = $request->input('is_rented');
        $rent->detail = $request->input('detail');
        $rent->price = $request->input('price');

        $rent->save();
 
        if( $request->expectsJson() )
        {
            return $this->successJson();
        }
        else
        {
            return redirect('/houtai/rents');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
