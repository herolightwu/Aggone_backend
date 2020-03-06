<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoryReply extends Model
{
    protected $table = 'storyreplies';

    protected $fillable = [
        'story_id',
        'user_id',
        'reply_type',//1-chat, 2-image
        'content',
        'timestamp',
    ];

    public function story()
    {
        return $this->belongsTo('App\Models\Story', 'story_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
