<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Youtube_infos extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'channel_id',
        'followers',
        'videos',
        'views',
        'description',
        'accessToken',
        'refreshToken'
    ];
}
