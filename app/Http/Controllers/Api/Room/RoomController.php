<?php

namespace App\Http\Controllers\Api\Room;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request){
        //Just for testing to get  rooms without Resource
        return Room::all();
    }
    public function show(Request $request){
        $room = Room::where('token',$request->token)->first();
        $data = [
            'room'=>null ? false:$room,
        ];
        return $data;
    }
    public function store(Request $request){
        $num = rand(0,1);
        $data = [
            'random'=>false,
            'room'=>null,

        ];
        if ($num){
            $data['room'] =  Room::all()->random()->first();
            $data['random'] = true;
        }
        else{
            
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            
            //https://stackoverflow.com/questions/4356289/php-random-string-generator
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
   
            $data['room'] =  Room::create([
                'token'=>$randomString
            ]);
        }
        return $data;
    }
}
