<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyDetail extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyDetailFactory> */
    use HasFactory,HasUlids;
    
    protected $guarded = [];

    public function property():BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
