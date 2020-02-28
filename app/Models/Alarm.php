<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alarm extends Model
{
    protected $table = 'alarms';

    protected $guarded = [];

    protected $fillable = [
        'content_msg',
        'user_id',
        'type',
        'sender_id',
        'timestamp',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }


    public function sender(){
        return $this->belongsTo('App\Models\User', 'sender_id');
    }
}
