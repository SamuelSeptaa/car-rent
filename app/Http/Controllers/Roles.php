<?php

namespace App\Http\Controllers;

use App\Models\SideBarMenu;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DataTables;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class Roles extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('view roles')) {
            abort(403);
        }
        $this->data['title']        = "Car Rent | User Roles";
        $this->data['script']       = "admin.roles.script.index";
        return $this->renderTo('admin.roles.index');
    }

    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create roles')) {
            abort(403);
        }
        $this->data['title']        = "Car Rent | Create User Roles";
        $this->data['script']       = "admin.roles.script.create";
        return $this->renderTo('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create roles')) {
            return $this->responseJSONFailedPermission('create roles');
        }

        $request->validate([
            'name'                  => ['required', 'unique:roles,name', 'regex:/^[a-zA-Z\s]+$/', 'min:4', 'max:255'],
        ]);

        Role::create(['name' => $request->name]);

        return response()->json([
            'status' => 'Success',
            'message'   => 'New role has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('view roles')) {
            return $this->responseJSONFailedPermission('view roles');
        }

        $query      = Role::select('*');

        return DataTables::of($query)
            ->addColumn('action', function ($query) {
                return '<div class="btn-group" role="group">
                    <a href="' . route('detail-role', ['id' => $query->id]) . '" type="button" class="btn btn-sm btn-primary">Detail</a>
                    <a href="' . route('detail-role-permission', ['id' => $query->id]) . '" type="button" class="btn btn-sm btn-info">Group Authorization</a>
                    <button onclick="deleteData(' . $query->id . ')"type="button" class="btn btn-sm btn-warning">Delete</button>
                </div>';
            })
            ->filter(function ($query) use ($request) {
                $this->YajraColumnSearch(
                    $query,
                    ['name'],
                    $request->search
                );
            })
            ->editColumn('updated_at', function ($query) {
                return parseTanggal($query->updated_at);
            })
            ->rawColumns(['action'])
            ->removeColumn(['id'])
            ->make(true);
    }


    public function detail($id)
    {
        if (!auth()->user()->hasPermissionTo('detail roles')) {
            abort(403);
        }
        $this->data['title']        = "Car Rent | Detail Role";
        $this->data['detail']       = Role::findOrFail($id);
        $this->data['script']       = "admin.roles.script.detail";
        return $this->renderTo('admin.roles.detail');
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
        if (!auth()->user()->hasPermissionTo('update roles')) {
            return $this->responseJSONFailedPermission('update roles');
        }
        if ($id == 1)
            return response()->json([
                'status' => 'Failed',
                'message'   => "Cannot update this default role"
            ], 403);

        $request->validate([
            'name'                  => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:4', 'max:255'],
        ]);

        Role::where('id', $id)->update(['name' => $request->name]);
        return response()->json([
            'status' => 'Success',
            'message'   => 'The role has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('delete roles')) {
            return $this->responseJSONFailedPermission('delete roles');
        }

        $id = $request->id;
        if ($id == 1) {
            return response()->json([
                'status' => 'Failed',
                'message'   => "Cannot delete this default role"
            ], 403);
        }

        $userCount      = User::select('users.*', 'roles.name as role_name')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id', '!=', 1)
            ->where('roles.id', $id)->count();
        if ($userCount > 0)
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'You have to change the role of users with this role before deleting this role'
            ], 400);

        Role::where('id', $id)->delete();
        return response()->json([
            'status' => 'Success',
            'message'   => 'The roles has been deleted'
        ], 200);
    }

    public function permission($id)
    {
        if (!auth()->user()->hasPermissionTo('view user-group-authorization')) {
            abort(403);
        }

        $data       = Permission::select(DB::raw("SUBSTRING(name, 6) AS menu_name"))
            ->where('name', 'like', 'view%')->orderBy('id', 'asc')->get();

        $all_menu    = array();
        foreach ($data as $d) {
            $d->permission_list = Permission::select('role_has_permissions.permission_id as is_has_permission', 'permissions.name', 'permissions.id')
                ->leftJoin('role_has_permissions', function ($join) use ($id) {
                    $join->on('role_has_permissions.permission_id', '=', 'permissions.id')
                        ->where('role_has_permissions.role_id', $id);
                })
                ->where('name', 'like', "%$d->menu_name")
                ->get();
            array_push($all_menu, $d->menu_name);
        }
        $permission_list            =   Permission::select('role_has_permissions.permission_id as is_has_permission', 'permissions.name', 'permissions.id')
            ->leftJoin('role_has_permissions', function ($join) use ($id) {
                $join->on('role_has_permissions.permission_id', '=', 'permissions.id')
                    ->where('role_has_permissions.role_id', $id);
            })
            ->where(function ($query) use ($all_menu) {
                foreach ($all_menu as $value) {
                    $query->where('name', 'not like', "%$value");
                }
            })->get();

        if (!$permission_list->isEmpty()) {
            $other_permission = new Permission;
            $other_permission->menu_name = 'Other Permission';
            $other_permission->permission_list = $permission_list;
            $data->push($other_permission);
        }
        $user_role                  = Role::findOrFail($id);
        $this->data['role']         = $user_role;
        $this->data['detail']       = $data;
        $this->data['title']        = "Car Rent | Permission For $user_role->name";


        $this->data['script']       = "admin.roles.script.permission";

        return $this->renderTo('admin.roles.permission');
    }

    public function update_permission(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('update user-group-authorization')) {
            return $this->responseJSONFailedPermission('update user-group-authorization');
        }
        DB::beginTransaction();
        try {
            Role::findOrFail($id)->syncPermissions($request->permission_id);
            DB::commit();
            return response()->json([
                'status' => 'Success',
                'message'   => 'The roles permission has been changed'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'Failed',
                'message'   => "Transaction failed: " . $e->getMessage()
            ], 500);
        }
    }
}
