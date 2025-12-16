<?php

namespace App\Services\Property;

use App\Models\District;
use App\Models\Province;
use App\Models\Subdistrict;
use Illuminate\Database\Eloquent\Collection;

class GeoLocationService
{
    public static function getProvinces(): Collection
    {
        return Province::all();
    }

    public static function getDistrctByProvince(Province $province): Collection
    {
        return District::where('p_code', $province->p_code)->get();
    }

    public static function getSubdistrictByDistrict(District $district): Collection
    {
        return Subdistrict::where('d_code', $district->d_code)->get();
    }
    
}
