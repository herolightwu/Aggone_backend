<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'phone',
        'password',
        'group_id',
        'is_active',
        'photo_url',
        'sport_id',
        'city',
        'category',
        'position',
        'country',
        'gender_id',
        'club',
        'age',
        'height',
        'weight',
        'year',
        'month',
        'day',
        'contract',
        'web_url',
        'desc_str',
        'available_club',
        'push_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userviews()
    {
        return $this->hasMany('App\Models\UserView', 'viewed_id');
    }

    public function storyviews()
    {
        return $this->hasMany('App\Models\StoryView', 'user_id');
    }

    public function storyreplies()
    {
        return $this->hasMany('App\Models\StoryReply', 'user_id');
    }

    public function stories()
    {
        return $this->hasMany('App\Models\Story', 'user_id');
    }

    public function alarms()
    {
        return $this->hasMany('App\Models\Alarm', 'user_id');
    }

    public function alarm_sender()
    {
        return $this->hasMany('App\Models\Alarm', 'sender_id');
    }

    public function feeds()
    {
        return $this->hasMany('App\Models\Feed', 'user_id');
    }

    public function admobs()
    {
        return $this->hasMany('App\Models\Admob', 'user_id');
    }

    public function social()
    {
        return $this->hasOne('App\Models\Social');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function cities()
    {
        return $this->belongsToMany('App\Models\City');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\UserGroup');
    }

    public function sport()
    {
        return $this->belongsTo('App\Models\Sport', 'sport_id');
    }

}
