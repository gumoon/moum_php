<?php

namespace moum\Http\Controllers\Admin;

use Illuminate\Http\Request;
use moum\Models\One14;
use Config;
use Illuminate\Validation\Rule;
use moum\Http\Controllers\Controller;

class One14Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $one14s = One14::all();
        foreach($one14s AS &$one14)
        {
            foreach($this->one14Categories AS $cat)
            {
                if($one14->cat_id == $cat['id'])
                {
                    $one14->cat_name = $cat['name'];
                    foreach($cat['types'] AS $type)
                    {
                        if($one14->type_id == $type['id'])
                        {
                            $one14->type_name = $type['name'];
                            break;
                        }
                    }
                    break;
                }
            }
        }

        return view('admin.one14s.index', ['one14s' => $one14s]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.one14s.create', ['one14Categories' => $this->one14Categories]);
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
            'name' => 'bail|required|unique:one14s,name',
            'cat_id' => 'bail|required|integer|min:0',
            'type_id' => 'bail|required|integer|min:0',
            'tel' => 'bail|required'
        ]);

        $one14 = new One14;
        $one14->name = $request->input('name');

        $image_url = $request->input('image_url');
        if( $image_url )
        {
            $one14->image_url = $image_url;
        }
        
        $one14->cat_id = $request->input('cat_id');
        $one14->type_id = $request->input('type_id');
        $one14->tel = $request->input('tel');

        $lat = $request->input('lat');
        if( $lat )
        {
            $one14->lat = $lat;
        }
        
        $lng = $request->input('lng');
        if( $lng )
        {
           $one14->lng = $lng; 
        }
        
        $addr = $request->input('addr');
        if( $addr )
        {
            $one14->addr = $addr;
        }
        
        $one14->is_vip = $request->input('is_vip');

        $detail = $request->input('detail');
        if( $detail )
        {
            $one14->detail = $detail;
        }
        
        $tags = $request->input('tags');
        if( $tags )
        {
            $one14->tags = $tags;
        }

        $one14->save();
 
        if( $request->expectsJson() )
        {
            return $this->successJson();
        }
        else
        {
            return redirect('/houtai/one14s');
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

        $one14 = One14::findOrFail($id);

        //头图
        $one14->image_url_src = empty($one14->image_url) ? '' : Config::get('app.ossDomain'). $one14->image_url;

        $one14Categories = collect($this->one14Categories)->keyBy('id');

        return view('admin.one14s.edit', ['one14' => $one14, 'one14Categories' => $one14Categories]);
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
            'name' => Rule::unique('one14s')->ignore($id, 'id'),
            'cat_id' => 'bail|required|integer|min:0',
            'type_id' => 'bail|required|integer|min:0',
            'tel' => 'bail|required'
        ]);

        $id = intval($id);

        $one14 = One14::find($id);
        $one14->name = $request->input('name');

        $image_url = $request->input('image_url');
        if( $image_url )
        {
            $one14->image_url = $image_url;
        }
        
        $one14->cat_id = $request->input('cat_id');
        $one14->type_id = $request->input('type_id');
        $one14->tel = $request->input('tel');

        $lat = $request->input('lat');
        if( $lat )
        {
            $one14->lat = $lat;
        }
        
        $lng = $request->input('lng');
        if( $lng )
        {
           $one14->lng = $lng; 
        }
        
        $addr = $request->input('addr');
        if( $addr )
        {
            $one14->addr = $addr;
        }
        
        $one14->is_vip = $request->input('is_vip');

        $detail = $request->input('detail');
        if( $detail )
        {
            $one14->detail = $detail;
        }
        
        $tags = $request->input('tags');
        if( $tags )
        {
            $one14->tags = $tags;
        }

        $one14->save();
 
        if( $request->expectsJson() )
        {
            return $this->successJson();
        }
        else
        {
            return redirect('/houtai/one14s');
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

    /**
     * 根据cat_id 获取 types
     * 
     */
    public function getTypesByCatId(Request $request)
    {
        $cat_id = $request->input('cat_id');

        foreach($this->one14Categories AS $key => $cat)
        {
            if($cat['id'] == $cat_id)
            {
                return $this->successJson($this->one14Categories[$key]['types']);
            }
        }
    }
}
