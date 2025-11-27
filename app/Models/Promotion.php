<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'title',
        'description',
        'discount_percent',
        'start_date',
        'end_date',
        'image',
        'is_active'
    ];
}
