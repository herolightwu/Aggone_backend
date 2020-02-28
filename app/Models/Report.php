<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'type',//user->1, feed->2 (default), story->3
        'rep_id',
        'description',
    ];
}
