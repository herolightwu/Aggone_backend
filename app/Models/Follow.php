<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follows';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'follow_id', //I followed follow_id's user
    ];
}
