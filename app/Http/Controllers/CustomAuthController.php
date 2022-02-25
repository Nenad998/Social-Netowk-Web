<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CustomAuthController extends Controller
{

    public function customRegistration(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $gender = $request->gender;

        $slug = Str::slug($request->name);

        $user = new User();

        if ($request->file('image')) {
            $avatar = $request->file('image');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(200, 126)->save( public_path('storage/' . $filename) );
            $user->image = $filename;
        }

        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->gender = $gender;
        $user->slug = $slug;
        $user->save();

        Auth::login($user);

        return redirect("/user/dashboard");
    }

    public function showCustomLogin()
    {
        return view('auth.custom-login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/user/dashboard')
                ->withSuccess('Signed in');
        }

        return redirect('customLogin');
    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return Redirect('/loginNenad');
    }
}
