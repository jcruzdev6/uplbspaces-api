<?php

namespace App\Http\Controllers\API;

use App\Models\Facility;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\FacilityResource;
use App\Http\Resources\API\FacilityCollection;
use Illuminate\Database\QueryException;
use PDOException;
use Log;


class FacilityController extends Controller
{
    public function index(Facility $facility)
    {
        return new FacilityCollection($facility->orderBy('name', 'asc')->get());
    }

    public function show(Facility $facility)
    {
        return new FacilityResource($facility);
    }

    public function getFacilityByType($facility_type)
    {
        try {
            $facilities = Facility::where('facility_type_id', $facility_type)->orderBy('name', 'asc')->get();
            return new FacilityCollection($facilities);
        } catch (QueryException $e) {
            if ($e->getPrevious() instanceof PDOException) {
                return response()->json(['error' => 'Invalid facility type'], 400);
            }
            throw $e;
        }
    }
}
