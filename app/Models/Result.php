<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'club',
        'sport_id',
        'type',
        'value',
        'year',
        'month',
    ];
}
