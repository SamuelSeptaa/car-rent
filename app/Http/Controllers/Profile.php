<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Profile extends Controller
{
    public function index()
    {
        $this->data['title']        = "Car Rent | Profile";
        $this->data['detail']       = User::findOrFail(auth()->user()->id);
        $this->data['script']       = "admin.users.script.detail";
        return $this->renderTo('admin.users.detail');
    }
}
