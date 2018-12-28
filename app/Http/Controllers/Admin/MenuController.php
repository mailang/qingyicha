<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Wemenu;
use EasyWeChat\Kernel\Exceptions\Exception;

class MenuController extends Controller
{
    /*菜单推送到公众号*/
    function  push_menu()
    {
        try{
        $buttons=array();
        $list=Wemenu::where('pid',0)->where('enable',1)->get();
        foreach ($list as $key=>$item){
             $arr=$this->arr_menu($item);
             if ($item->type=="none")
             {
                 $sub=Wemenu::where('pid',$item->id)->where('enable',1)->get();
                 $children=array();
                 foreach ($sub as $child)
                 {
                     $children= array_merge($children, $this->arr_menu($child));
                 }
                 $arr=array_merge($arr,array('sub_button'=>$children));
             }
            $buttons= array_merge($buttons,$arr);
        }
            $app = app('wechat.official_account');
           $msg=$app->menu->create($buttons);
            //"errcode":48001,"errmsg":"api unauthorized hint
            $msg=\GuzzleHttp\json_decode($msg);
            if ($msg["errcode"]!="")
                return $msg["errmsg"];
            else
            return "操作成功";
        }
        catch (Exception $ex){
            return abort('400',$ex->getMessage());
            }
    }
    function  arr_menu($item)
    {
        $type=$item->type;
        $arr=array();
        switch ($type)
        {
            case "none":array_push($arr,array('name'=>$item->name));break;
            case "view": array_push($arr,array('type'=>$type,'name'=>$item->name,'url'=>$item->url)); break;
            case "click": array_push($arr,array('type'=>$type,'name'=>$item->name,'key'=>$item->key)); break;
            case "miniprogram":array_push($arr,array('type'=>$type,'name'=>$item->name,'url'=>$item->url,'appid'=>$item->appid,'pagepath'=>$item->pagepath)); break;
            case "media_id":array_push($arr,array('type'=>$type,'name'=>$item->name,'media_id'=>$item->media_id)); break;
            case "view_limited":array_push($arr,array('type'=>$type,'name'=>$item->name,'media_id'=>$item->media_id)); break;
            default:array_push($arr,array('type'=>$type,'name'=>$item->name,'key'=>$item->key)); break;
        }
        return $arr;

    }
    /*ajax请求返回菜单的json数据*/
    function getdata()
    {
        $list=Wemenu::all(['id','pid','name','type','key','url','enable']);//::where("enable",1)->get(['id','pid','name','type','key','url','enable']);
         echo \GuzzleHttp\json_encode($list->ToArray());
    }
    /*进入编辑添加菜单页*/
    function  create($id=null)
    {
        if($id)
        {
            $sub=0;
            $menu=Wemenu::find($id);
            if ($menu->pid>0)
            {
                //二级菜单
                $child=Wemenu::find($menu->pid);
                 $pname=$child->name;
            }
               else
               {
                   $sub=count(Wemenu::where('pid',$id)->get());
                   $pname="一级菜单";
               }
            return view('admin.wechat.edit',compact('menu','pname','sub'));
        }
        else
        {
            $clm=Wemenu::where('pid',0)->where('sub',1)->get(['id','name']);
            return view('admin.wechat.add',compact('clm'));
        }
    }

    /*增加记录*/
    function  store(Request $request)
    {
        $req=$request->all();
        $column=Wemenu::where('pid',$req['pid'])->where('enable',1)->get();
        $num=count($column);
        if ($req['pid']==0&&$num>=3) return "可用一级菜单已达极限(3个)";
         if ($req['pid']>0&&$num>=5) return "该栏目下二级菜单添加已达到极限(5个)";
        if($req['type']=="none"&&$req["pid"]==0)
            $req["sub"]=1;
        else $req["sub"]=0;
        Wemenu::create($req);
        return "操作成功";

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id)
    {
        try{
        $wemenu= Wemenu::find($id);
        $wemenu->delete([$id]);
        return "删除成功";
         } catch (Exception $e) {}
    }

    /*更新微信菜单*/
    function  update_menu(Request $request)
    {
        $req=$request->all();
        $menu=Wemenu::find($req["id"]);
        $type=$req["type"];
        switch ($type)
        {
            case "none": $menu["name"]=$req["name"];$menu["type"]=$type; $menu["key"]=$menu["url"]=$menu["media_id"]=$menu["appid"]=$menu["pagepath"]="";break;
            case "view": $menu["name"]=$req["name"];$menu["type"]=$type; $menu["url"]=$req["url"]; $menu["key"]=$menu["media_id"]=$menu["appid"]=$menu["pagepath"]="";break;
            case "click": $menu["name"]=$req["name"];$menu["type"]=$type; $menu["key"]=$req["key"];$menu["url"]=$menu["media_id"]=$menu["appid"]=$menu["pagepath"]="";break;
            case "miniprogram": $menu["name"]=$req["name"];$menu["type"]=$type; $menu["url"]=$req["url"]; $menu["appid"]=$req["appid"]; $menu["pagepath"]=$req["pagepath"]; $menu["key"]=$menu["url"]=$menu["media_id"]="";break;
            case "media_id": $menu["name"]=$req["name"];$menu["type"]=$type;$menu["media_id"]=$req["media_id"];$menu["key"]=$menu["url"]=$menu["appid"]=$menu["pagepath"]="";break;
            case "view_limited": $menu["name"]=$req["name"];$menu["type"]=$type; $menu["media_id"]=$req["media_id"];$menu["key"]=$menu["url"]=$menu["appid"]=$menu["pagepath"]="";break;
            default: $menu["name"]=$req["name"];$menu["type"]=$type; $menu["key"]=$req["key"];$menu["url"]=$menu["media_id"]=$menu["appid"]=$menu["pagepath"]="";break;
        }
        $pid=$menu["pid"];
        if($req['type']=="none"&&$pid==0)
            $menu["sub"]=1;
        else $menu["sub"]=0;
        if($req["enable"]==1&&$menu->enable==0)
        {
            $column=Wemenu::where('pid',$pid)->where('enable',1)->get();
            $num=count($column);
            if ($pid==0&&$num>=3) return "可用一级菜单已达极限(3个)";
            if ($pid>0&&$num>=5) return "该栏目下二级菜单添加已达到极限(5个)";
        }
        $menu["enable"]=$req["enable"];
        $menu->save();
        return "操作成功";
    }
}
