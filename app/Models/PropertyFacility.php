<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\Pivot;  // Changed from Model
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyFacility extends Pivot  // Changed from Model
{
    use HasUlids;

    protected $table = 'property_facilities';  // Add this
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'property_id',
        'facility_id',
    ];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}