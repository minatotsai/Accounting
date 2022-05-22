<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function check(Request $request)
    {
        
        $pass = $request->input();
        if($request->input('pass') == env('LOGIN_PASS'))
            return view('main');
        else
            echo "fail";
    }
}
