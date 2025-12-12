<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectFacility extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFacilityFactory> */
    use HasFactory;

    // timestamps off
    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'facility_id',
    ];

    /**
     * Summary of project
     * @return BelongsTo<Project, $this>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Summary of facility
     * @return BelongsTo<Facility, $this>
     */
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }
}
