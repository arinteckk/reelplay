<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TVShow extends Model
{
    use HasFactory;

    protected $table = 'tv_show';
    protected $guarded = array();

    public function type()
    {
        return $this->belongsTo(Type::class,'type_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class,'channel_id');
    }
    
}
