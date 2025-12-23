<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyLocationElement extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyLocationElementFactory> */
    use HasFactory,HasUlids;

    protected $fillable = [
        'name',
        'details',
        'distance',
        'property_id',
        'location_element_id',
    ];

    public function locationElement()
    {
        return $this->belongsTo(LocationElement::class);
    }
}
