<?php

namespace moum\Http\Controllers\Admin;

use moum\Http\Requests\StoreShopPost;
use moum\Models\Shop;
use moum\Http\Controllers\Controller;


class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::all();

        return view('admin.shops.index', ['shops' => $shops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShopPost $request)
    {
        $program = new Shop;

        $program->name = $request->input('name');
        $program->intro = $request->input('intro');
        $program->type = $request->input('type');
        $program->status = $request->input('status');

        $program->save();

        if( $request->expectsJson() )
        {
            $ret = array(
                'errno' => 0,
                'msg' => 'success',
                'data' => array()
            );

            return response()->json($ret);
        }
        else
        {
            return redirect('/houtai/shops');
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

        $shop = Shop::findOrFail($id);

        return view('admin.shops.edit', ['shop' => $shop]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreShopPost $request, $id)
    {
        $id = intval($id);
        $program = Shop::find($id);

        $program->name = $request->input('name');
        $program->intro = $request->input('intro');
        $program->type = $request->input('type');
        $program->status = $request->input('status');

        $program->save();

        if( $request->expectsJson() )
        {
            $ret = array(
                'errno' => 0,
                'msg' => 'success',
                'data' => array('')
            );

            return response()->json($ret);
        }
        else
        {
            return redirect('/houtai/shops');
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
