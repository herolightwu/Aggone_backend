<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroup extends Model
{
    use SoftDeletes;

    protected $table = 'user_groups';

    protected $fillable = [
        'id',
        'title',
        'description',
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
