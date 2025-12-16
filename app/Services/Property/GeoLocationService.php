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

    public static function getDistrctByProvince(string $p_code): Collection
    {
        return District::where('p_code', $p_code)->get();
    }

    public static function getSubdistrictByDistrict(string $d_code): Collection
    {
        return Subdistrict::where('d_code', $d_code)->get();
    }

    public static function getZipcodeBySubdistrict(string $s_code): string
    {
        return Subdistrict::where('s_code', $s_code)->first()->zip_code;
    }
}
