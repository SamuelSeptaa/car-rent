<?php

namespace App\Http\Controllers;

use App\Models\SideBarMenu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $data = [];
    protected $userId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::id(); // Get the user's ID and store it as a property
            $userId = $this->userId;
            $this->data['sidemenus']        = SideBarMenu::whereIn("permission_name", function ($query) use ($userId) {
                $query->select('permissions.name')
                    ->from('role_has_permissions')
                    ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where('role_has_permissions.role_id', function ($subquery) use ($userId) {
                        $subquery->select('model_has_roles.role_id')
                            ->from('model_has_roles')
                            ->where('model_has_roles.model_id', $userId);
                    });
            })->where('header', null)->get();
            return $next($request);
        });

        $this->data['title']  = "Car Rent";

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }



    protected function YajraFilterValue(
        $filterValue,
        $query,
        $columnFilter,
        $join = false,
        $table = null,
        $columnRelation = null,
        $tableJoin = null
    ) {
        if ($join)
            $query->join($tableJoin, "$table.$columnRelation", '=', "$tableJoin.id");

        $filterValue = json_decode($filterValue);
        if (!empty($filterValue)) {
            $query->whereIn($columnFilter, $filterValue);
        }
    }

    /**
     * YajraColumnSearch
     *
     * @param  mixed $query
     * @param  array $columnSearch
     * @param  string $searchValue
     * @return void
     */
    protected function YajraColumnSearch($query, $columnSearch, $searchValue)
    {
        $query->where(function ($query) use ($columnSearch, $searchValue) {
            $i = 0;
            foreach ($columnSearch as $item) {
                if ($i == 0)
                    $query->where($item, 'like', "%{$searchValue}%");
                else
                    $query->orWhere($item, 'like', "%{$searchValue}%");
                $i++;
            }
        });
    }

    /**
     * filterDateRange
     *
     * @param  mixed $query
     * @param  string $columnFilter
     * @param  object $request
     * @return void
     */
    protected function filterDateRange($query, $columnFilter, $request)
    {
        if ($request->startDate && $request->endDate) {
            $query->where($columnFilter, '>=', "$request->startDate 00:00:00");
            $query->where($columnFilter, '<=', "$request->endDate 23:59:59");
        }
    }


    protected function renderTo($file_name)
    {
        return view($file_name, $this->data);
    }

    /**
     * responseJSONFailedPermission
     *
     * @param  string $permission_name
     * @return void
     */
    protected function responseJSONFailedPermission($permission_name)
    {
        return response()->json([
            'status'    => "Failed",
            'message'   => "You do not have permission to access $permission_name"
        ], 403);
    }
}
