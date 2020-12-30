<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permisson\Model\Role;
use Spatie\Permisson\Model\Permission;
use DB;

class RoleController extends Controller
{
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //
        $this->middleware('permission:role-list|role-create|role-edit|role_delete',['only'=>['index','show']]);
        $this->middleware('permission:role-create',['only'=>['create','store']]);
        $this->middleware('permission:role-edit',['only'=>['edit','update']]);
        $this->middleware('permission:role-delte',['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('roles.index',compact('roles'))
                ->with('i',($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'name'  => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermission($request->input('permission'));

        return redirect()->route('roles.index')
                        ->with('success','Role created sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $role = Role::find($id);
        $rolePermission = Permission::join('role_has_permissions','role_has_permission.permission_id','=','permission_id')
            ->where('role_has_permissions.role_id',$id)
            ->get();
        return view('role.show',compact('role','rolePermission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermission = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id',$id)
            ->pluck('role_has_permission.permission_id','role_has_permission.permission_id')
            ->all();
        return view('role.edit',compact('role','permission','rolePermission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'name'=>'required',
            'permission'=>'required',
        ]);

        $role = Role::find($id);
        $role->name = $equest->input('name');
        $role->save();

        $role->syncPermission($request->input('permission'));

        return redirect()->route('roles.index')
                        ->with('success','Role updated sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(role $role)
    {
        //
        DB::table('roles')->where('id',$id)->delete();
        return redirect()->route(roles.index)
                        ->with('success','Role deleted sucessfully');
    }
}
