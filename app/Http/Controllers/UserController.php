<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function show_login()
    {
        return view('auth.login');
    }

    public function show_register()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        if (empty($request->name)) {
            Session::put('register', 'Tên không được để trống!');
            return redirect()->route('showRegister');
        }

        if (empty($request->phone)) {
            Session::put('register', 'Phone không được để trống!');
            return redirect()->route('showRegister');
        } else {
            $user = User::where('phone', $request->phone)->first();
            if (!empty($user)) {
                Session::put('register', 'Số điện thoại đã tồn tại!');
                return redirect()->route('showRegister');
            }
        }

        if (empty($request->email)) {
            Session::put('register', 'Email không được để trống!');
            return redirect()->route('showRegister');
        } else {
            $user = User::where('email', $request->email)->first();
            if (!empty($user)) {
                Session::put('register', 'Email đã tồn tại!');
                return redirect()->route('showRegister');
            }
        }

        if (!empty($request->email)) {
            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                Session::put('register', 'Định dạng email không hợp lệ!');
                return redirect()->route('showRegister');
            }
        }

        if (strlen($request->pass) < 6) {
            Session::put('register', 'Mật khẩu ít nhất 6 kí tự!');
            return redirect()->route('showRegister');
        }

        if (empty($request->pass) || empty($request->re_pass)) {
            Session::put('register', 'Mật khẩu không được để trống!');
            return redirect()->route('showRegister');
        } elseif ($request->pass != $request->re_pass) {
            Session::put('register', 'Mật khẩu không khớp!');
            return redirect()->route('showRegister');
        }

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = md5($request->pass);
        $user->status = 'new';
        $user->save();
        Session::remove('register');
        return redirect()->route('showLogin');
    }

    public function appLogin(Request $request)
    {
        $email = $request->email;
        $pass = md5($request->pass);
        $user = User::where('email', $email)->first();
        if (!empty($user)) {
            if ($user->email == $email && $user->password == $pass) {
                Session::put('user', $user);
                Session::remove('login');
                return redirect()->route('dashboard');
            } else {
                Session::put('login', 'Tên hoặc tài khoản không khớp!');
                return redirect()->route('showLogin');
            }
        } else {
            Session::put('login', 'Tài khoản không tồn tại! ');
            return redirect()->route('showLogin');
        }
    }

    public function dashboard()
    {
        return view('admin.dashboard.dashboard');
    }

    public function logout()
    {
        Session::remove('user');
        return redirect()->route('showLogin');
    }

    public function show_profile($id)
    {
        $user = User::find($id);
        return view('admin.dashboard.profile', compact('user'));
    }

    public function update_profile(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        if ($request->hasFile('avatar')) {
            //upload image
            $result = $request->file('avatar')->storeOnCloudinary();
            //get url image luu vao db
            $user->image = $result->getPath();
        }
        Session::put('message', 'Cập nhật thành công!');
        $user->save();
        Session::put('user', $user);
        return redirect()->route('showProfile', $id);
    }
}
