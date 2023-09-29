<?php

namespace App\Http\Controllers\API;

use App\Models\Facility;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\SearchResource;
use App\Http\Resources\API\SearchCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;
use Log;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        Log::info('keyword:'.$request['keyword']);
        $keyword = $request['keyword'];
        $capacity = $request['capacity'];
        $query = Facility::query();
        $query = $query->where(function($subquery) use ($keyword){
                                $subquery->where('name', 'ilike', '%'.$keyword.'%');
                                $subquery->orWhere('address', 'ilike', '%'.$keyword.'%');
                            });
        if ($request['category']) $query = $query->where('facility_type_id', $request['category']);
        if ($capacity) $query = $query->where(function($subquery) use ($capacity){
            $subquery->where('min_capacity', '<=', $capacity);
            $subquery->where('max_capacity', '>=', $capacity);
        });
        if ($request['college']) $query = $query->where('department_unit_id', $request['college']);                            
        $results = $query->get();
        Log::info('results:'.$results);
        return new SearchCollection($results);
    }

    public function searchGet($keyword)
    {
        $results = Facility::where('name', 'like', '%'.$keyword.'%')->get();
        return new SearchCollection($results);
    }
}
