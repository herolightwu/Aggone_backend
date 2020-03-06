<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserView extends Model
{
    protected $table = 'userviews';

    protected $fillable = [
        'user_id',
        'viewed_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'viewed_id');
    }

}
