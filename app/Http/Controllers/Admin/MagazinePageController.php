<?php

namespace moum\Http\Controllers\Admin;

use Illuminate\Http\Request;
use moum\Models\Spread;
use Config;
use moum\Http\Controllers\Controller;


class MagazinePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spreads = Spread::where('position_id', Spread::POSITION_MAGAZINE_PAGE)->get();
        foreach($spreads AS &$spread)
        {
            $spread->image_url_src = $spread->image_url ? Config::get('app.ossDomain'). $spread->image_url : '';
        }

        return view('admin.magazinePages.index', ['spreads' => $spreads]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.magazinePages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            //'image_url' => 'bail|required|max:255'
        ]);

        $spread = new Spread;
        $spread->title = $request->input('title');
        $spread->image_url = $request->input('image_url');
        $spread->position_id = Spread::POSITION_MAGAZINE_PAGE;
        $spread->extra = $request->input('extra');
        $spread->flag = $request->input('flag');

        $spread->save();
 
        if( $request->expectsJson() )
        {
            return $this->successJson();
        }
        else
        {
            return redirect('/houtai/magazinePages');
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

        $spread = Spread::findOrFail($id);

        //头图
        $spread->image_url_src = empty($spread->image_url) ? '' : Config::get('app.ossDomain'). $spread->image_url;

        return view('admin.magazinePages.edit', ['spread' => $spread]);
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

        $this->validate($request, [
            //'image_url' => 'bail|required|max:255'
        ]);

        $spread = Spread::find($id);
        $spread->title = $request->input('title');
        $spread->image_url = $request->input('image_url');
        $spread->extra = $request->input('extra');
        $spread->flag = $request->input('flag');

        $spread->save();
 
        if( $request->expectsJson() )
        {
            return $this->successJson();
        }
        else
        {
            return redirect('/houtai/magazinePages');
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
        $id = intval($id);

        $res = Spread::destroy($id);

        if( $res == 1 )
        {
            return $this->successJson();
        }
        else
        {
            return $this->failedJson('delete fail');
        }
        
    }
}
