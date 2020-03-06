<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = 'careers';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'position',
        'sport_id',
        'club',
        'logo',
        'location',
        'year',
        'month',
        'day',
        'tyear',
        'tmonth',
        'tday',
    ];
}
