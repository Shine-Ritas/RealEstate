<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory,HasUlids;

    protected $fillable = [
        'name',
        'slug',
        'developer_id',
        'description',
        'latitude',
        'longitude',
        'address',
        'district_id',
        'province_id',
        'total_floors',
        'total_units',
        'year_completed',
        'status',
    ];

    /**
     * Summary of facilities
     * @return BelongsToMany<Facility, $this>
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'project_facilities');
    }

    /**
     * Summary of developer
     * @return BelongsTo<Developer, $this>
     */
    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    /**
     * Summary of district
     * @return BelongsTo<District, $this>
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
    
    /**
     * Summary of province
     * @return BelongsTo<Province, $this>
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
