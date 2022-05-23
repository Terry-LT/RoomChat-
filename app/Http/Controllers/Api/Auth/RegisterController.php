<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'nickname'=>'required|unique:users,nickname',
            //'name'=>'unique:users,name',
            //'surname'=>'unique:users,surname',
            'email'=>'required|unique:users,email|email',
            'password'=>'required|min:8',
        ]);
        //https://shouts.dev/laravel-spa-with-vue3-auth-crud-example
        try{

            User::create([
                'nickname'=>$request->nickname,
                'name'=>$request->name,
                'surname'=>$request->surname,
                'email'=>$request->email,
                'password'=> Hash::make($request->password),
            ]);

            $success = true;
            $message = 'User register successfully';
        }
        catch (\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
        }
        //response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }
}
