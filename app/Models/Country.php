<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $table = 'countries';

    protected $fillable = [
        'country_name',
        'country_code',
        'iso_code'
    ];

    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }
}
