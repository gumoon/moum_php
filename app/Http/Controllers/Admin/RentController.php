<?php

namespace moum\Http\Controllers\Admin;

use Illuminate\Http\Request;
use moum\Http\Requests\StoreShopPost;
use moum\Models\Shop;
use Config;
use moum\Http\Controllers\Controller;


class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::all();

        return view('admin.shops.index', ['shops' => $shops, 'shopCats' => $this->shopCats, 'shopTypes' => $this->shopTypes]);
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
    public function store(StoreShopPost $request)
    {
        $shop = new Shop;
        $shop->name = $request->input('name');
        $shop->image_url = $request->input('image_url01');
        $shop->cat_id = $request->input('cat_id');
        $shop->type_id = $request->input('type_id');
        $shop->tel = $request->input('tel');
        $shop->boss_tel = $request->input('bosstel');
        $shop->open_time = $request->input('open_time');
        $shop->lat = $request->input('lat');
        $shop->lng = $request->input('lng');
        $shop->addr = $request->input('addr');
        $shop->is_vip = $request->input('is_vip');
        $shop->intro = $request->input('intro');

        $menu_image_urls['image_url11'] = $request->input('image_url11');
        $menu_image_urls['image_url21'] = $request->input('image_url21');
        $menu_image_urls['image_url31'] = $request->input('image_url31');
        $menu_image_urls['image_url41'] = $request->input('image_url41');

        $shop->menu_image_urls = json_encode( $menu_image_urls );

        $shop->save();
 
        if( $request->expectsJson() )
        {
            return $this->successJson();
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

        //头图
        $shop->image_url_src = empty($shop->image_url) ? '' : Config::get('app.ossDomain'). $shop->image_url;

        //菜单图
        $menu_image_urls = json_decode($shop->menu_image_urls, true);

        $shop->image_url11_src = empty($menu_image_urls['image_url11']) ? '' : Config::get('app.ossDomain').$menu_image_urls['image_url11'];
        $shop->image_url21_src = empty($menu_image_urls['image_url21']) ? '' : Config::get('app.ossDomain').$menu_image_urls['image_url21'];
        $shop->image_url31_src = empty($menu_image_urls['image_url31']) ? '' : Config::get('app.ossDomain').$menu_image_urls['image_url31'];
        $shop->image_url41_src = empty($menu_image_urls['image_url41']) ? '' : Config::get('app.ossDomain').$menu_image_urls['image_url41'];

        return view('admin.shops.edit', ['shop' => $shop, 'shopCats' => $this->shopCats, 'shopTypes' => $this->shopTypes, 'menu_image_urls' => $menu_image_urls]);
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
        $shop = Shop::find($id);
        
        $shop->name = $request->input('name');
        $shop->image_url = $request->input('image_url01');
        $shop->cat_id = $request->input('cat_id');
        $shop->type_id = $request->input('type_id');
        $shop->tel = $request->input('tel');
        $shop->boss_tel = $request->input('bosstel');
        $shop->open_time = $request->input('open_time');
        $shop->lat = $request->input('lat');
        $shop->lng = $request->input('lng');
        $shop->addr = $request->input('addr');
        $shop->is_vip = $request->input('is_vip');
        $shop->intro = $request->input('intro');

        $menu_image_urls['image_url11'] = $request->input('image_url11');
        $menu_image_urls['image_url21'] = $request->input('image_url21');
        $menu_image_urls['image_url31'] = $request->input('image_url31');
        $menu_image_urls['image_url41'] = $request->input('image_url41');

        $shop->menu_image_urls = json_encode( $menu_image_urls );

        $shop->save();
 
        if( $request->expectsJson() )
        {
            return $this->successJson();
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

    /**
     * 根据cat_id 获取 types
     * 
     */
    public function getTypesByCatId(Request $request)
    {
        $cat_id = $request->input('cat_id');

        if( isset( $this->shopTypes[$cat_id] ) )
        {
            return $this->successJson( $this->shopTypes[$cat_id] );
        }
    }
}
