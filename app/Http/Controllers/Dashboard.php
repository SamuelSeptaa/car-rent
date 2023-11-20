<?php

namespace App\Http\Controllers;

use App\Models\rent;
use App\Models\SideBarMenu;
use App\Models\User;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {
        $this->data['total_users']      = User::count();
        $this->data['total_menu']      = SideBarMenu::count();
        $this->data['total_transaction']      = rent::count();
        return $this->renderTo('admin.dashboard');
    }
}
