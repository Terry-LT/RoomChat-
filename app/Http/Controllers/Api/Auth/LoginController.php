<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(Request $request){
        //https://shouts.dev/laravel-spa-with-vue3-auth-crud-example
        if (Auth::attempt($request->only('email','password'),$request->remember_me)) {
            $success = true;
            $message = 'User login successfully';
        } else {
            $success = false;
            $message = 'Unauthorised';
        }
        // response
        $response = [
            'success' => $success,
            'message' => $message,
            'user' =>Auth::user(),
        ];
        return response()->json($response);
    }
}
