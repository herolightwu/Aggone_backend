<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admob extends Model
{
    protected $table = 'admobs';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'sport_id',
        'position',
        'description',
        'city',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
