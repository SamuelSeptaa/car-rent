<?php

namespace App\Http\Controllers;

use App\Models\SideBarMenu as ModelsSideBarMenu;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class SideBarMenu extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('view side_bar_menus')) {
            abort(403);
        }
        $this->data['title']        = "Car Rent | Menu";

        $this->data['script']       = "admin.menu.script.index";
        return $this->renderTo('admin.menu.index');
    }

    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create side_bar_menus')) {
            abort(403);
        }
        $this->data['title']        = "Car Rent | Create Menu";
        $this->data['header_list']  = ModelsSideBarMenu::where('header', null)->get();
        $this->data['script']       = "admin.menu.script.create";
        return $this->renderTo('admin.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create side_bar_menus')) {
            return $this->responseJSONFailedPermission('create side_bar_menus');
        }

        $request->validate([
            'title' => ['required', 'unique:side_bar_menus,title', 'min:4', 'max:25'],
            'uri' => ['required', 'unique:side_bar_menus,uri', 'regex:/^[A-Za-z0-9\/-]+$/', 'min:4', 'max:25'],
            'icon' => [Rule::requiredIf($request->header())],
        ]);
        $permission_slug = createSlug($request->title);

        DB::beginTransaction();
        try {
            if ($request->is_has_data_manipulation) {
                Permission::create(['name' => "view $permission_slug"]);
                Permission::create(['name' => "create $permission_slug"]);
                Permission::create(['name' => "detail $permission_slug"]);
                Permission::create(['name' => "update $permission_slug"]);
                Permission::create(['name' => "delete $permission_slug"]);
            } else {
                Permission::create(['name' => "view $permission_slug"]);
                $request->is_has_data_manipulation = "NO";
            }


            ModelsSideBarMenu::create([
                'title'                     => $request->title,
                'uri'                       => $request->uri,
                'icon'                      => $request->icon,
                'permission_name'           => "view $permission_slug",
                'header'                    => $request->header,
                'is_has_data_manipulation'  => $request->is_has_data_manipulation,
            ]);
            DB::commit();

            return response()->json([
                'status' => 'Success',
                'message'   => 'New menu has been created'
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
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('view side_bar_menus')) {
            return $this->responseJSONFailedPermission('view side_bar_menus');
        }
        $query      = ModelsSideBarMenu::select('*');
        return DataTables::of($query)
            ->addColumn('action', function ($query) {
                return '
                <div class="btn-group" role="group">
                    <a href="' . route('detail-menu', ['id' => $query->id]) . '" type="button" class="btn btn-primary">Detail</a>
                    <button onclick="deleteData(' . $query->id . ')"type="button" class="btn btn-warning">Delete</button>
                </div>
                ';
            })
            ->filter(function ($query) use ($request) {
                $this->YajraColumnSearch(
                    $query,
                    ['title', 'uri'],
                    $request->search
                );
            })

            ->rawColumns(['action', 'icon'])
            ->removeColumn(['id'])
            ->make(true);
    }

    public function detail($id)
    {
        if (!auth()->user()->hasPermissionTo('detail side_bar_menus')) {
            abort(403);
        }
        $this->data['title']            = "Car Rent | Edit Menu";
        $this->data['detail']           = ModelsSideBarMenu::where("id", $id)->firstOrFail();
        $this->data['header_list']      = ModelsSideBarMenu::where('header', null)->where('id', '!=', $id)->get();
        $this->data['script']           = "admin.menu.script.detail";
        return $this->renderTo('admin.menu.detail');
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
        if (!auth()->user()->hasPermissionTo('update side_bar_menus')) {
            return $this->responseJSONFailedPermission('edit side_bar_menus');
        }

        $request->validate([
            'title'         => ['required', "unique:side_bar_menus,title,$id", 'min:4', 'max:25'],
            'icon'          => [Rule::requiredIf($request->header())],
        ]);

        DB::beginTransaction();
        try {
            ModelsSideBarMenu::where("id", $id)
                ->update([
                    'title'                     => $request->title,
                    'icon'                      => $request->icon,
                    'header'                    => $request->header,
                ]);

            DB::commit();
            return response()->json([
                'status' => 'Success',
                'message'   => 'The menu has been updated'
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('delete side_bar_menus')) {
            return $this->responseJSONFailedPermission('delete side_bar_menus');
        }

        $id = $request->id;
        if ($id <= 5)
            return response()->json([
                'status' => 'Failed',
                'message'   => "Cannot delete default menu"
            ], 403);
        DB::beginTransaction();
        try {
            $menu                   = ModelsSideBarMenu::where("id", $id)->firstOrFail();
            $permission_slug_delete = explode(" ", $menu->permission_name)[1];
            //delete previous permission name
            Permission::where('name', "view $permission_slug_delete")->delete();
            Permission::where('name', "create $permission_slug_delete")->delete();
            Permission::where('name', "detail $permission_slug_delete")->delete();
            Permission::where('name', "update $permission_slug_delete")->delete();
            Permission::where('name', "delete $permission_slug_delete")->delete();
            //

            ModelsSideBarMenu::where("id", $id)->delete();

            DB::commit();
            return response()->json([
                'status' => 'Success',
                'message'   => 'The menu has been deleted'
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
