<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admins;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Roles;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list=Admins::all();
        return view('admin.admins.list',compact('list'));
    }

    /*后台登录用户修改密码*/
    public function  modify($id)
    {
        $roleid=0;
        $admins=Admins::find($id);
        $arr= $admins->roles->toArray();
        if ($arr) $roleid=$arr[0]["pivot"]["role_id"];
        $roles=Roles::find($roleid);
        return  view('admin.admins.my',compact('admins','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *如果id为空则创建新账号，否则编辑账号
     */
    public function create($id=null)
    {
        $roles=Roles::all();
        $roleid=0;
        if ($id)
        {
            $admins=Admins::find($id);
            $arr= $admins->roles->toArray();
            if ($arr) $roleid=$arr[0]["pivot"]["role_id"];
            return  view('admin.admins.edit',compact('admins','roles','roleid'));
        }
        else return view('admin.admins.add',compact('roles'));
    }

    public function update(Request $request)
    {
            $req=$request->all();
            $new=$req['new'];
            $admins=Admins::find($new['id']);
            $admins->username=$new['username'];
            $admins->realname=$new['realname'];
            if ($new['password']!=""&&$new['password2']!="") {
                if ($new['password'] == $new['password2']) {
                    $admins['password'] = bcrypt($new['password']);
                } else return "两次密码输入不一致";
            }
            $admins->save();
            /*角色更新*/
            $admins->detachRole($admins->roles[0]);//已有角色回收
            $admins->attachRole($req['roles'][0]);//重新分配新角色
            return "操作成功";

    }
    /*删除后台用户，删除用户
    * 删除角色
    * */
    public function destroy($id)
    {
        if ($id)
        {
            $admin = Admins::find((int)$id);
            $admin->delete([$id]);
            //echo url()->current();
            flash("操作成功");
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $req=$request->all();
        $new=$req['new'];
        $exist= Admins::where('username',$new['username'])->first();
        if ($exist){ return '该用户已经存在';}
        if ($new['password']==$new['password2']) {
            $new['password']=bcrypt($new['password']);
            $admin=Admins::create($new);
            /*角色添加*/
            $role=Roles::find($req['roles'][0]);
            //调用EntrustUserTrait提供的attachRole方法
            $admin->attachRole($role); // 参数可以是Role对象，数组或id
            return '操作成功';
        }
        else return '两次密码输入不一致';
    }
}
