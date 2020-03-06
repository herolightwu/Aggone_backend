<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $table = 'bookmarks';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'feed_id',
    ];
}
