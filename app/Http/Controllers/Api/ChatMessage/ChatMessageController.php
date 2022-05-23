<?php

namespace App\Http\Controllers\Api\ChatMessage;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;

class ChatMessageController extends Controller
{
    public function index(Request $request){
        $request->validate([
            'room_token'=>'required'
        ]);
        $room = Room::where('token',$request->room_token)->first();
        return $room->chat_message_resources();
    }
    public function store(Request $request){
        $request->validate([
            'room_token'=>'required',
            'body'=>'required|min:1',
        ]);
        $room = Room::where('token',$request->room_token)->first();
        
        $room->chat_messages()->create([
            'body'=>$request->body,
            'user_id'=>$request->user_id,
        ]);

        return true;

    }

    public function destroy($message_id){
        $chat_message = ChatMessage::findOrFail($message_id);
        //to check that the user is owner of that message
        $this->authorize('delete',$chat_message);

        $chat_message->delete();

        return 1;

    }
    public function update(Request $request,$message_id){
        $request->validate([
            'room_token'=>'required',
            'body'=>'required|min:1',
        ]);

        $chat_message = ChatMessage::findOrFail($message_id);
        //to check that the user is owner of that message
        $this->authorize('update',$chat_message);

        $chat_message->update($request->only('body'));
        
        return 1;
    }
}
