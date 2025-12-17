<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyFacility extends Model
{
    use HasUlids;

    protected $fillable = [
        'property_id',
        'facility_id',
    ];

    public function facility() : BelongsTo{
        return $this->belongsTo(Facility::class);
    }

    public function property() : BelongsTo{
        return $this->belongsTo(Property::class);
    }
}
