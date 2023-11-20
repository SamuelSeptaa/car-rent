<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class Permissions extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('view permissions')) {
            abort(403);
        }
        $this->data['title']        = "Car Rent | Permissions";
        $this->data['script']       = "admin.permissions.script.index";
        return $this->renderTo('admin.permissions.index');
    }

    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create permissions')) {
            abort(403);
        }
        $this->data['title']        = "Car Rent | Create Permissions";
        $this->data['script']       = "admin.permissions.script.create";
        return $this->renderTo('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create permissions')) {
            return $this->responseJSONFailedPermission('create permissions');
        }

        $request->validate([
            'name'      => ['required', 'min:4', 'max:255', 'regex:/^[A-Za-z\s\/-]+$/']
        ]);

        Permission::create(['name' => $request->name]);

        return response()->json([
            'status' => 'Success',
            'message'   => 'New permission has been created'
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
        if (!auth()->user()->hasPermissionTo('view permissions')) {
            return $this->responseJSONFailedPermission('view permissions');
        }

        $query      = Permission::select("*");
        return DataTables::of($query)
            ->addColumn('action', function ($query) {
                return '<div class="btn-group" role="group">
                    <a href="' . route('detail-permission', ['id' => $query->id]) . '" type="button" class="btn btn-primary">Detail</a>
                    <button onclick="deleteData(' . $query->id . ')"type="button" class="btn btn-warning">Delete</button>
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
        if (!auth()->user()->hasPermissionTo('detail permissions')) {
            abort(403);
        }
        $this->data['title']        = "Car Rent | Detail Permission";
        $this->data['detail']       = Permission::findOrFail($id);
        $this->data['script']       = "admin.permissions.script.detail";
        return $this->renderTo('admin.permissions.detail');
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
        if (!auth()->user()->hasPermissionTo('update permissions')) {
            return $this->responseJSONFailedPermission('update permissions');
        }
        if ($id <= 22)
            return response()->json([
                'status'        => 'Failed',
                'message'       => 'Cannot update default permission'
            ], 400);

        $request->validate([
            'name'      => ['required', "unique:permissions,name,$id", 'min:4', 'max:255', 'regex:/^[A-Za-z\s\/-]+$/']
        ]);

        Permission::where('id', $id)->update([
            'name'      => $request->name
        ]);

        return response()->json([
            'status'        => 'Success',
            'message'       => 'The permission has been updated'
        ], 200);
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
        if ($id <= 22)
            return response()->json([
                'status'        => 'Failed',
                'message'       => 'Cannot delete default permission'
            ], 400);
        DB::beginTransaction();
        try {
            Permission::where('id', $id)->delete();
            DB::commit();
            return response()->json([
                'status' => 'Success',
                'message'   => 'The permission has been deleted'
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
