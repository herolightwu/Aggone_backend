<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $table = 'stories';

    protected $fillable = [
        'user_id',
        'image',
        'timebeg',
        'timeend',
        'tags',
    ];

    public function storyreply()
    {
        return $this->hasMany('App\Models\StoryReply', 'story_id');
    }

    public function storyviews()
    {
        return $this->hasMany('App\Models\StoryView', 'story_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
