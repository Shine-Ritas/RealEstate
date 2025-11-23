<?php

namespace App\Services\Clients;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class VendorClient
{
    protected string $baseUrl = '';

    public function __construct(){
        $this->baseUrl = 'https://raw.githubusercontent.com/kongvut/thai-province-data/refs/heads/master/api/latest';
    }

    public function client(): PendingRequest{
        // return http client that accept endpoint with json response
        return Http::baseUrl($this->baseUrl);
    }

    public function getProvinces(): Response{
        return $this->client()->get('province.json');
    }

    public function getDistricts(): Response{
        return $this->client()->get('district.json');
    }

    public function getSubdistricts(): Response{
        return $this->client()->get('sub_district.json');
    }
}
