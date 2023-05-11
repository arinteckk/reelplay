<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'video';
    protected $guarded = array();

    public function type()
    {
        return $this->belongsTo(Type::class,'type_id');
    }

}
