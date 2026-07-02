<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['user_id', 'body', 'channel'];

    // Yeh function batata hai ke message kis user ka hai
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}