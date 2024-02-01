<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'p_name',
        'p_price',
        'p_type',
        'status',
    ];

    // public function content() {
    //     return $this->hasOne('App\Models\Content');
    // }
    // public function Companies(){
    //     return $this->hasMany('App\Models\Company');
    // }
}
