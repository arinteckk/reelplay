<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video_Watch extends Model
{
    use HasFactory;

    protected $table = 'video_watch';
    protected $guarded = array();
}
