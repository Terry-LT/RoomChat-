<?php

namespace App\Models;

use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ChatMessageResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'token',
        
    ];

    public function chat_messages(){
        return $this->hasMany(ChatMessage::class);
    }
    public function chat_message_resources(){
        return ChatMessageResource::collection(
            ChatMessage::where('room_id',Room::where('token',$this->token)->first()->id
            )->get());
    }
}
