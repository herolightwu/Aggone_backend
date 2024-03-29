<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $table = 'resumes';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'resume_url',
    ];
}
