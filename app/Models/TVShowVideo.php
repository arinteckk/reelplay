<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TVShowVideo extends Model
{
    use HasFactory;

    protected $table = 'tv_show_video';
    protected $guarded = array();

    public function show()
    {
        return $this->belongsTo(TVShow::class,'show_id');
    }
}
