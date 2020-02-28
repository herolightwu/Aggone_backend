<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
{
    protected $table = 'recommends';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'recommend_id', //I followed follow_id's user
    ];
}
