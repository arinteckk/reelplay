<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transction extends Model
{
    use HasFactory;

    protected $table = 'transaction';
    protected $guarded = array();

    public function package()
    {
        return $this->belongsTo(Package::class,'package_id');
    }

    public function user()
    {
        return $this->belongsTo(Users::class,'user_id');
    }
}
