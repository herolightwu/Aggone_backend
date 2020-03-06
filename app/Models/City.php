<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    //use SpatialTrait;

    protected $table = 'cities';

    protected $fillable = [
        'city_name',
//        'zip_code',
    ];

    protected $spatialFields = [
        'location',
    ];

    protected $country;

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

//    public function restaurants()
//    {
//        return $this->hasMany('App\Models\Restaurant');
//    }
}
