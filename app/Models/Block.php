<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'blocks';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'blocked_id', //I followed follow_id's user
    ];
}
