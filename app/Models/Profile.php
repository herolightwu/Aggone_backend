<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'location',
        'bio',
        'google_username',
        'facebook_username',
        'avatar',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
