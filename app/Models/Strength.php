<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strength extends Model
{
    protected $table = 'strengths';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'strength',
    ];


}
