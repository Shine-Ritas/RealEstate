<?php

namespace App\Models;

use App\Enums\ListingTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Str;

class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory,HasUlids;

    protected $guarded = [];

    // boot
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($property) {
            $property->slug = Str::slug($property->name);
            $last_property = Property::orderBy('created_at', 'desc')->first();
            $prefix = (string) config('control.property_prefix', 'PR');
            $last_property_code = $last_property?->property_code;

            $last_property_code_number = 0;
            if (is_string($last_property_code) && str_starts_with($last_property_code, $prefix)) {
                $last_property_code_number = (int) substr($last_property_code, strlen($prefix));
            }

            $property->property_code = $prefix.str_pad((string) ($last_property_code_number + 1), 7, '0', STR_PAD_LEFT);
        });

        static::updating(function ($property) {
            $property->slug = Str::slug($property->name);
        });
    }

    // has_image get attribute
    public function getHasImageAttribute(): bool
    {
        return $this->images()->exists();
    }

    public function getPrimaryImageAttribute(): string
    {
        return $this->images()->where('is_primary', true)->first()?->image_url
            ?? $this->images()->first()?->image_url
            ?? asset('assets/no_image.jpg');
    }

    public function getNormalShowPriceAttribute(): string
    {
        $price = match ($this->listing_type) {
            ListingTypeEnum::Sale->value => $this->sale_price ,
            ListingTypeEnum::Rent->value => $this->rent_price ,
            ListingTypeEnum::Both->value => $this->current_price,
            default => null,
        };

        return $price ? currency().' '.number_format($price, 0) : 'N/A';
    }

    public function getShowPricePeriodAttribute(): string
    {
        return match ($this->listing_type) {
            ListingTypeEnum::Sale->value => '> Sale',
            ListingTypeEnum::Rent->value => '/ Month',
            ListingTypeEnum::Both->value => 'Both',
            default => null,
        };
    }

    public function getShowPriceAttribute(): string
    {
        $price = match ($this->listing_type) {
            ListingTypeEnum::Sale->value => $this->sale_price ,
            ListingTypeEnum::Rent->value => $this->rent_price ,
            ListingTypeEnum::Both->value => $this->current_price,
            default => null,
        };

        $extra = match ($this->listing_type) {
            ListingTypeEnum::Sale->value => '> Sale',
            ListingTypeEnum::Rent->value => '/ Month',
            ListingTypeEnum::Both->value => 'Both',
            default => null,
        };

        return $price ? currency().' '.number_format($price, 0).' '.$extra : 'N/A';
    }

    public function detail(): HasOne
    {
        return $this->hasOne(PropertyDetail::class);
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(
            Facility::class,
            'property_facilities',
            'property_id',
            'facility_id'
        )
            ->using(PropertyFacility::class)
            ->withPivot('id')  // Important: tell Laravel about the pivot ID
            ->withTimestamps();
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'p_code', 'p_code');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'd_code', 'd_code');
    }

    public function subdistrict(): BelongsTo
    {
        return $this->belongsTo(Subdistrict::class, 's_code', 's_code');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function locationElements(): HasMany
    {
        return $this->hasMany(PropertyLocationElement::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(PropertyContact::class);
    }

    public function preferences(): HasMany
    {
        return $this->hasMany(Preference::class);
    }
}
