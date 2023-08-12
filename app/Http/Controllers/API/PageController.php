<?php

namespace App\Http\Controllers\API;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\PageResource;
use App\Http\Resources\API\PageCollection;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    public function index(Page $page)
    {
        return new PageCollection($page->where('status', 'Active')->orderBy('rank', 'asc')->get());
    }

    public function show(Page $page)
    {
        if ($page->status == 'Active')
            return new PageResource($page);
        else
           return new JsonResponse([], 200);
           //return new PageResource((object)[]);
    }
}
