<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Descript extends Model
{
    protected $table = 'descripts';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'type',
        'value',
    ];
}
