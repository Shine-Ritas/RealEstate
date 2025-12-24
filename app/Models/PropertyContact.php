<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyContact extends Model
{
    use HasUlids;

    protected $fillable = [
        'property_id',
        'type',
        'text',
        'icon',
        'contact_type',
        'url',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

}
