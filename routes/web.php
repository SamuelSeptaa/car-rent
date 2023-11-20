<?php

use App\Http\Controllers\Car;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Login;
use App\Http\Controllers\Permissions;
use App\Http\Controllers\Profile;
use App\Http\Controllers\Roles;
use App\Http\Controllers\SideBarMenu;
use App\Http\Controllers\Transaction;
use App\Http\Controllers\Users;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [Login::class, 'index'])->name('login');
    Route::post('/loging-in', [Login::class, 'loging_in'])->name('loging-in');

    Route::get('/register', [Login::class, 'register'])->name('register');
    Route::post('/register-in', [Login::class, 'register_in'])->name('register-in');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [Login::class, 'logout'])->name('logout');
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

    Route::prefix('admin/profile')->group(function () {
        Route::get('/', [Profile::class, 'index'])->name("profile");
        Route::post('/update', [Profile::class, 'update'])->name("update-profile");
    });

    Route::prefix('admin/menu')->group(function () {
        Route::get('/', [SideBarMenu::class, 'index'])->name("menu");
        Route::post('/show', [SideBarMenu::class, 'show'])->name("show-menu");
        Route::get('/create', [SideBarMenu::class, 'create'])->name("create-menu");
        Route::post('/store', [SideBarMenu::class, 'store'])->name("store-menu");
        Route::get('/detail/{id}', [SideBarMenu::class, 'detail'])->name("detail-menu");
        Route::post('/update/{id}', [SideBarMenu::class, 'update'])->name("update-menu");
        Route::post('/destroy', [SideBarMenu::class, 'destroy'])->name("destroy-menu");
    });

    Route::prefix('admin/user')->group(function () {
        Route::get('/', [Users::class, 'index'])->name("user");
        Route::post('/show', [Users::class, 'show'])->name("show-user");
        Route::get('/create', [Users::class, 'create'])->name("create-user");
        Route::post('/store', [Users::class, 'store'])->name("store-user");
        Route::get('/detail/{id}', [Users::class, 'detail'])->name("detail-user");
        Route::post('/update/{id}', [Users::class, 'update'])->name("update-user");
        Route::post('/destroy', [Users::class, 'destroy'])->name("destroy-user");
    });

    Route::prefix('admin/role')->group(function () {
        Route::get('/', [Roles::class, 'index'])->name("role");
        Route::post('/show', [Roles::class, 'show'])->name("show-role");
        Route::get('/create', [Roles::class, 'create'])->name("create-role");
        Route::post('/store', [Roles::class, 'store'])->name("store-role");
        Route::get('/detail/{id}', [Roles::class, 'detail'])->name("detail-role");
        Route::post('/update/{id}', [Roles::class, 'update'])->name("update-role");
        Route::post('/destroy', [Roles::class, 'destroy'])->name("destroy-role");
        Route::get('/detail/{id}/permission', [Roles::class, 'permission'])->name("detail-role-permission");
        Route::post('/update/{id}/permission', [Roles::class, 'update_permission'])->name("update-role-permission");
    });

    Route::prefix('admin/permission')->group(function () {
        Route::get('/', [Permissions::class, 'index'])->name("permission");
        Route::post('/show', [Permissions::class, 'show'])->name("show-permission");
        Route::get('/create', [Permissions::class, 'create'])->name("create-permission");
        Route::post('/store', [Permissions::class, 'store'])->name("store-permission");
        Route::get('/detail/{id}', [Permissions::class, 'detail'])->name("detail-permission");
        Route::post('/update/{id}', [Permissions::class, 'update'])->name("update-permission");
        Route::post('/destroy', [Permissions::class, 'destroy'])->name("destroy-permission");
    });

    Route::prefix('dashboard/kendaraan')->group(function () {
        Route::get('/', [Car::class, 'index'])->name("kendaraan");
        Route::post('/show', [Car::class, 'show'])->name("show-kendaraan");
        Route::get('/create', [Car::class, 'create'])->name("create-kendaraan");
        Route::post('/store', [Car::class, 'store'])->name("store-kendaraan");
        Route::get('/detail/{id}', [Car::class, 'detail'])->name("detail-kendaraan");
        Route::post('/update/{id}', [Car::class, 'update'])->name("update-kendaraan");

        Route::get('/request-rent/{id}', [Car::class, 'rent'])->name("rent-kendaraan");
        Route::post('/create-rent/{id}', [Car::class, 'create_rent'])->name("rent-kendaraan");
    });

    Route::prefix('dashboard/transactions')->group(function () {
        Route::get('/', [Transaction::class, 'index'])->name("transaksi-rental");
        Route::post('/show', [Transaction::class, 'show'])->name("show-transaksi-rental");
        Route::get('/return/{id}', [Transaction::class, 'return'])->name("return-transaksi-rental");
        Route::post('/do_return/{id}', [Transaction::class, 'do_return'])->name("do-return-transaksi-rental");
    });
});
