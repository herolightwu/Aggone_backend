<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $table = 'prizes';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'title',
        'club',
        'year',
        'icon',
    ];
}
