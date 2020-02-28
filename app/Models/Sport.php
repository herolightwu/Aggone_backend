<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

//    use SoftDeletes;

    protected $table = 'sports';

    protected $fillable = [
        'id',
        'name',
//        'image',
        'description',
    ];

}
