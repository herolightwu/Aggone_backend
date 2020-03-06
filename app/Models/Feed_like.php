<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed_like extends Model
{
    protected $table = 'feed_likes';

    protected $guarded = [];

    protected $fillable = [
        'feed_id',
        'user_id',
    ];

    public function feed(){
        return $this->belongsTo("App\Models\Feed", "feed_id");
    }
}
