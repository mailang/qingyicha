<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use function MongoDB\BSON\toJSON;

class MenuController extends Controller
{

    protected $menu;
    public function __construct() {
        $app = app('wechat.official_account');
        $this->menu = $app->menu;
    }
    /*
     * 尝试去获取当前微信里面的菜单，如果菜单存在，那么就调用SDK里面的list方法获取到，
     *然后返回给前端显示，如果没有菜单，那么就返回一个空数组。
     */
    function edit() {
        $buttons = Cache::rememberForever('wechat_config_menus', function () { $list = $this->menu->list();
        //获取所有菜单
            if (isset($list['menu'])) {
                return $list['menu']['button']; } return []; });
        $jsonbtn=\GuzzleHttp\json_encode($buttons);

        return view('admin.wechat.list', compact('buttons','jsonbtn'));
    }

    /*自定义菜单*/
    function create_menu($menu)
    {
        $this->menu->create($menu);
    }

    /*更新微信菜单*/
    function  update_menu(Request $request)
    {
        $req=$request->all();
        $this->menu->delete();

        $this->create_menu(arr($req['menu']));
    }
}
