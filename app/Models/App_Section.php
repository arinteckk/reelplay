<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_Section extends Model
{
    use HasFactory;

    protected $table = 'app_section';
    protected $guarded = array();
    
    public function type()
    {
        return $this->belongsTo(Type::class,'type_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
