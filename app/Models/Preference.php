<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Preference extends Model
{
    /** @use HasFactory<\Database\Factories\PreferenceFactory> */
    use HasFactory,HasUlids;

    protected $guarded = [];

    public function property():BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

  
}
