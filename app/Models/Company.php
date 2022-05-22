<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    // public function content() {
    //     return $this->hasOne('App\Models\Content');
    // }
    public function contents(){
        return $this->hasMany('App\Models\Content');
    }
}
