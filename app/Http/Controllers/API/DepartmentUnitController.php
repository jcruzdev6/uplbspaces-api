<?php

namespace App\Http\Controllers\API;

use App\Models\DepartmentUnit;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\DepartmentUnitResource;
use App\Http\Resources\API\DepartmentUnitCollection;
use Illuminate\Database\QueryException;
use PDOException;
use Log;


class DepartmentUnitController extends Controller
{
    public function index(DepartmentUnit $department_unit)
    {
        return new DepartmentUnitCollection($department_unit->orderBy('name', 'asc')->get());
    }

    public function show(DepartmentUnit $department_unit)
    {
        return new DepartmentUnitResource($department_unit);
    }
}
