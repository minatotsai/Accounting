<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function company() {
        return $this->belongsTo('App\Models\Company');
    }

    protected $fillable = [
        'content',
        'amount',
        'company_id',
        'memo',
        'price',
        'quantity',
        'up_at',
    ];
}
