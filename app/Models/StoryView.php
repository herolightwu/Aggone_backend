<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoryView extends Model
{
    protected $table = 'storyviews';

    protected $fillable = [
        'story_id',
        'user_id',
        'view_count',
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
