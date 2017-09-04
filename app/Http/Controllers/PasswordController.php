<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PasswordRequest;
use Hash;

class PasswordController extends Controller
{
    public function index()
    {
        return view('user.password');
    }

    public function update(PasswordRequest $request)
    {
        if (Hash::check($request->get('old_password'), user()->password)){
            user()->password = Hash::make($request->get('password'));
            user()->save();
            flash('修改成功', 'success');
            return back();
        }
        flash('旧密码输入错误', 'danger');
        return back();
    }
}
