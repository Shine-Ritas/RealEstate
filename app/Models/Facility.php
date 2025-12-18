<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    /** @use HasFactory<\Database\Factories\FacilityFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description',
        'status',
    ];

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(
            Property::class, 
            'property_facilities',
            'facility_id',
            'property_id'
        )
        ->using(PropertyFacility::class)
        ->withPivot('id')
        ->withTimestamps();
    }
}
