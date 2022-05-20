<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function passAuth(Request $request)
    {
        
        $pass = $request->input();
        if($request->input('pass') == env('LOGIN_PASS'))
            echo "ok";
        else
            echo "fail";
    }
}
