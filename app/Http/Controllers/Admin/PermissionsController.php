<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permissions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pid=null)
    {
        if ($pid){
            $permissions=DB::table('permissions')->where('pid', $pid)->get();
        }else
            $permissions=DB::table('permissions')->where('pid', '-1')->get();
        return view('admin.permission.list',compact('permissions','pid'));
    }
     /*子栏目*/
    public function child($id)
    {
        $permissions=DB::table('permissions')->where('pid', $id)->get();
        return view('admin.permission.child',compact('permissions'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        $permission=DB::table('permissions')->where('pid', '-1')->get();
        if ($id) {
            $per=Permissions::find($id);
            return view('admin.permission.edit', compact('permission','per'));
        } else{return view('admin.permission.add',compact('permission'));}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *   "name" => "d"
    "display_name" => "d"
    "icon" => "fa-sign-out"
    "description" => null
    "pid" => "-1"
     */
    public function store(Request $request)
    {
        $permission=$request->all();
        $permission['display_name']=$permission['name'];
        //dd($permission);
        $exist=Permissions::where('name',$permission['name'])->first();
        if ($exist) { return "该模块已经添加";}
        else{
            $insert=Permissions::create($permission);
            if ($insert)return  "操作成功";
            else return '操作失败';
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
            $new=$request->all();
            $permission=Permissions::find($new["id"]);
            $permission['url']=$new['url'];
            $permission['description']=$new['description'];
            $permission['pid']=$new['pid'];
           $permission['name']=$new['name'];
            $permission->save();
            echo "操作成功";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $child = Permissions::where('pid', $id)->first();
        if ($child) {
            DB::table('Permissions')->where('pid',"=",$id)->delete();
        }
            $permission= Permissions::find($id);
            $permission->delete([$id]);
            return "删除成功";


    }
}
