<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $table = 'feeds';

    protected $guarded = [];

    protected $fillable = [
        'type', //normal-0, youtube-1, articles-2
        'user_id',
        'title',
        'video_url',
        'thumbnail_url',
        'sport_id',
        'view_count',
        'timestamp',
        'shared',
        'articles',
        'tagged',
        'mode',
        'desc_str',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Feed_like', 'feed_id');
    }
}
