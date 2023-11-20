<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Login extends Controller
{
    public function index()
    {
        return $this->renderTo('login');
    }

    public function loging_in(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email:dns'],
                'password' => ['required']
            ]
        );

        if (Auth::attempt($credentials, $request->remember)) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('login')->with('failed', 'Invalid login credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function register()
    {
        // $this->data['terms_and_condition'] =
        //     Cache::remember('terms_and_condition', now()->addSecond(300), function () {
        //         return term_and_condition::find(1);
        //     });
        return $this->renderTo('register');
    }

    public function register_in(Request $request)
    {
        $request->validate([
            'name'                  => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:5', 'max:255'],
            'email'                 => ['required', 'unique:users,email', 'email:dns', 'max:255'],
            'phone'                 => ['required', 'unique:users,phone', 'digits_between:10,13', 'starts_with:08'],
            'sim_number'            => ['required', 'unique:users,sim_number', 'digits:12'],
            'address'               => ['required', 'max:255'],
            'password'              => ['required', 'min:5'],
            'password-confirm'      => ['same:password'],
        ]);

        if ($request->agree === null)
            return response()->json([
                'status' => 'Failed',
                'message'   => "You must agree to our Term and Conditions!"
            ], 400);

        DB::beginTransaction();
        try {
            $member     = User::create([
                'name'                  => $request->name,
                'email'                 => $request->email,
                'phone'                 => $request->phone,
                'sim_number'            => $request->sim_number,
                'address'               => $request->address,
                'password'              => bcrypt($request->password),
            ]);
            $member->assignRole('Member');

            DB::commit();
            return response()->json([
                'status'        => 'Success',
                'message'       => "Registration success, you can now <a href=" . route('login') . ">Login</a>"
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'Failed',
                'message'   => "Transaction failed: " . $e->getMessage()
            ], 500);
        }
    }
}
