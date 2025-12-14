<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationElement extends Model
{
    /** @use HasFactory<\Database\Factories\LocationElementFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description',
        'status',
    ];
}
