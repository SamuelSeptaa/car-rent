<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('view users')) {
            abort(403);
        }
        $this->data['title']        = "Car Rent | Users";
        $this->data['roles']        = Role::all();
        $this->data['script']       = "admin.users.script.index";
        return $this->renderTo('admin.users.index');
    }

    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create users')) {
            abort(403);
        }
        $this->data['title']        = "Car Rent | Create User";
        $this->data['roles']        = Role::all();
        $this->data['script']       = "admin.users.script.create";
        return $this->renderTo('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create users')) {
            return $this->responseJSONFailedPermission('create users');
        }

        $request->validate([
            'name'                  => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:5', 'max:255'],
            'email'                 => ['required', 'unique:users,email', 'email:dns', 'max:255'],
            'password'              => ['required', 'min:5'],
            'password_confirmation' => ['required', 'same:password'],
            'role_id'               => ['required'],
        ]);

        $role       = Role::findOrFail($request->role_id);

        $user       = User::create(
            [
                'name'          => $request->name,
                'email'         => $request->email,
                'password'      => bcrypt($request->password),
            ]
        );
        $user->assignRole($role->name);

        return response()->json([
            'status' => 'Success',
            'message'   => 'New user has been created'
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
        if (!auth()->user()->hasPermissionTo('view users')) {
            return $this->responseJSONFailedPermission('view users');
        }

        $query      = User::select('users.*', 'roles.name as role_name')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id', '!=', 1);


        return DataTables::of($query)
            ->addColumn('action', function ($query) {
                return '<div class="btn-group" role="group">
                    <a href="' . route('detail-user', ['id' => $query->id]) . '" type="button" class="btn btn-primary">Detail</a>
                    <button onclick="deleteData(' . $query->id . ')"type="button" class="btn btn-warning">Delete</button>
                </div>';
            })
            ->filter(function ($query) use ($request) {
                $this->YajraColumnSearch(
                    $query,
                    ['users.name', 'email'],
                    $request->search
                );
                $this->YajraFilterValue($request->filterValue, $query, "role_id");
            })
            ->editColumn('updated_at', function ($query) {
                return parseTanggal($query->updated_at);
            })
            ->rawColumns(['action'])
            ->removeColumn(['id', 'password', 'remember_token', 'created_at'])
            ->make(true);
    }

    public function detail($id)
    {
        if (!auth()->user()->hasPermissionTo('detail users')) {
            abort(403);
        }
        $this->data['title']        = "Car Rent | Detail User";
        $this->data['detail']       = User::select('users.*', 'roles.id as role_id')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id', $id)->firstOrFail();

        $this->data['roles']        = Role::all();
        $this->data['script']       = "admin.users.script.detail";
        return $this->renderTo('admin.users.detail');
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
        if (!auth()->user()->hasPermissionTo('update users')) {
            return $this->responseJSONFailedPermission('update users');
        }
        $request->validate([
            'name'                  => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:5', 'max:255'],
            'email'                 => ['required', 'unique:users,email,' . $id, 'email:dns', 'max:255'],
            'password'              => ['nullable', 'min:5'],
            'password_confirmation' => ['same:password'],
            'role_id'               => ['required'],
        ]);
        if ($id == 1)
            return response()->json([
                'status' => 'Failed',
                'message'   => "Cannot update this user"
            ], 403);

        DB::beginTransaction();
        try {
            $role       = Role::findOrFail($request->role_id);

            if ($request->password)
                User::where('id', $id)->update([
                    'name'      => $request->name,
                    'email'     => $request->email,
                    'password'  => bcrypt($request->password),
                ]);
            else
                User::where('id', $id)->update([
                    'name'      => $request->name,
                    'email'     => $request->email,
                ]);

            User::findOrFail($id)->syncRoles($role->name);

            DB::commit();
            return response()->json([
                'status' => 'Success',
                'message'   => 'The user has been updated'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'Failed',
                'message'   => "Transaction failed: " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('delete users')) {
            return $this->responseJSONFailedPermission('delete users');
        }

        $id = $request->id;
        if ($id == 1) {
            return response()->json([
                'status' => 'Failed',
                'message'   => "Cannot delete this user"
            ], 403);
        }
        DB::beginTransaction();
        try {
            User::findOrFail($id)->syncRoles([]);
            User::where('id', $id)->delete();
            DB::commit();
            return response()->json([
                'status' => 'Success',
                'message'   => 'The user has been deleted'
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
