<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Roles::all();
        return view('admin.roles.list',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        $permissions=Permissions::all();
        if ($id)
        {
            $roles=Roles::find($id);
            //获取角色已有的权限
            $permitids=array();
            if ($roles->perms) {
                foreach ($roles->perms as $v) {
                    $permitids[] = $v->id;
                }
            }
            return  view('admin.roles.edit',compact('permissions','roles','permitids'));
        }
        else return view('admin.roles.add',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role=$request->all();
        $roles["display_name"]=$role['name'];
        $roles["name"]=$role['name'];
        $roles["description"]=$role['description'];
        $newrole=Roles::create($roles);
        $permissions=$role['permissions'];
        if ($newrole&&$permissions)
        {
            $newrole->attachPermissions($permissions);
            return "操作成功";
        }
        else return "操作失败";

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
        //
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
        //
            $new=$request->all();
            $role=Roles::find($new["id"]);
            $role->name=$new['name'];
            $role->save();
            /*权限更新*/
            // dd($role->perms);
            $permitids=array();
            foreach ($role->perms as $v) {
                $permitids[] = $v->id;
            }
            if ($permitids) $role->detachPermissions($permitids);//已有权限回收
            //dd($req['permissions'][0]);
            if(isset($new['permissions']))
            $role->attachPermissions($new['permissions']);//重新分配新权限
            return "操作成功";
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
        if ($id)
        {
            $roles=Roles::find($id);
            //  dd($role);
            if ($roles)
            {
                $roles->delete([$id]);
               return "删除成功";
            }
        }
    }

}
