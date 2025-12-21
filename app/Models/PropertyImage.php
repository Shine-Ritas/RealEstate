<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyImage extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [];

    // Rename the accessor to avoid conflict
    public function getImageUrlAttribute(): string
    {
        return url(asset('storage/' . $this->attributes['image_path']));
    }
    
    // Or if you want a full URL accessor
    public function getFullImagePathAttribute(): string
    {
        return url(asset('storage/' . $this->attributes['image_path']));
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}