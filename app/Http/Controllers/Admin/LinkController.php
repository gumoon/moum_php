<?php

namespace moum\Http\Controllers\Admin;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use moum\Models\Link;
use Config;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $links = Link::withTrashed()->get();
        $links = Link::all();
        foreach($links AS &$link)
        {
            $link->icon_src = Config::get('app.ossDomain').$link->icon;
        }

        return view('admin.links.index', ['links' => $links]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.links.create');
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
            'nation_id' => 'bail|required|in:0,1', 
            'name' => 'bail|required|max:255',
            'icon' => 'bail|required|max:255',
            'url' => 'bail|required|max:255'
        ]);

        $nation_id = $request->input('nation_id');
        $name = $request->input('name');
        $url = $request->input('url');
        $icon = $request->input('icon');
        $data = array(
            'nation_id' => $nation_id,
            'name' => $name,
            'url' => $url,
            'icon' => $icon
        );

        $link = new Link;
        $link->nation_id = $nation_id;
        $link->name = $name;
        $link->icon = $icon;
        $link->url = $url;
        $link->save();

        return $this->successJson($data);
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
        $link = Link::find($id);
        $link->icon_src = Config::get('app.ossDomain').$link->icon;

        return view('admin.links.edit', ['link' => $link]);
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
        $this->validate($request, [
            'nation_id' => 'bail|required|in:0,1', 
            'name' => 'bail|required|max:255',
            'icon' => 'bail|required|max:255',
            'url' => 'bail|required|max:255'
        ]);

        $nation_id = $request->input('nation_id');
        $name = $request->input('name');
        $url = $request->input('url');
        $icon = $request->input('icon');

        $data = array(
            'nation_id' => $nation_id,
            'name' => $name,
            'url' => $url,
            'icon' => $icon
        );
        
        $link = Link::findOrFail($id);
        $link->nation_id = $nation_id;
        $link->name = $name;
        $link->icon = $icon;
        $link->url = $url;
        $link->save();

        return $this->successJson($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Link::destroy($id);
        // Link::withTrashed()->where('id' , $id)->restore();
        return $this->successJson();
    }
}
