<?php

namespace App\Http\Controllers\API;

use App\Models\FacilityRate;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\FacilityRateResource;
use App\Http\Resources\API\FacilityRateCollection;

class FacilityRateController extends Controller
{
    public function index(FacilityRate $facility_rate)
    {
        return new FacilityRateCollection($facility_rate->latest()->get());
    }

    public function show(FacilityRate $facility_rate)
    {
        return new FacilityRateResource($facility_rate);
    }

    public function with($request)
    {
        return [
            'isSuccess' => true
        ];
    }   
}

    