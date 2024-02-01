<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Company extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name',
        'status',
    ];

    // public function content() {
    //     return $this->hasOne('App\Models\Content');
    // }
    public function contents(){
        return $this->hasMany(Content::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
