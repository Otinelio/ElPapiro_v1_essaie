<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pub extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'image',
        'position',
        'page',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

}
