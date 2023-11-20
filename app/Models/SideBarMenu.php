<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SideBarMenu extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function submenu($header_id)
    {
        $userId = auth()->user()->id;
        return
            SideBarMenu::whereIn("permission_name", function ($query) use ($userId) {
                $query->select('permissions.name')
                    ->from('role_has_permissions')
                    ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where('role_has_permissions.role_id', function ($subquery) use ($userId) {
                        $subquery->select('model_has_roles.role_id')
                            ->from('model_has_roles')
                            ->where('model_has_roles.model_id', $userId);
                    });
            })->where('header', $header_id)->get();
    }
}
