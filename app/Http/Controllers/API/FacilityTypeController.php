<?php

namespace App\Http\Controllers\API;

use App\Models\FacilityType;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\FacilityTypeResource;
use App\Http\Resources\API\FacilityTypeCollection;
use Illuminate\Database\QueryException;
use PDOException;
use Log;


class FacilityTypeController extends Controller
{
    public function index(FacilityType $facility_type)
    {
        return new FacilityTypeCollection($facility_type->orderBy('rank', 'asc')->get());
    }

    public function show(FacilityType $facility_type)
    {
        return new FacilityTypeResource($facility_type);
    }

    public function getFacilityByType($type)
    {
        try {
            $facilities = FacilityType::where('type', $type)->get();
            return new FacilityTypeCollection($facilities);
        } catch (QueryException $e) {
            if ($e->getPrevious() instanceof PDOException) {
                return response()->json(['error' => 'Invalid facility type'], 400);
            }
            throw $e;
        }
    }
}
