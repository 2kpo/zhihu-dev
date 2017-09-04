<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function avatar()
    {
        return view('user.avatar');
    }

    public function upload(Request $request)
    {
        $img = $request->file('img');
        $filename = md5(time().user()->id).'.'.$img->getClientOriginalExtension();
        $img->move(public_path('avatar'),$filename);
        user()->avatar = '/avatar/'.$filename;
        user()->save();
        return ['url' => user()->avatar];
    }
}
