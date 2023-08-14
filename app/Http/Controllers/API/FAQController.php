<?php

namespace App\Http\Controllers\API;

use App\Models\FAQ;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\FAQResource;
use App\Http\Resources\API\FAQCollection;
use Illuminate\Http\JsonResponse;

class FAQController extends Controller
{
    public function index(FAQ $faq)
    {
        return new FAQCollection($faq->where('enabled', true)->orderBy('rank', 'asc')->get());
    }

    public function show(FAQ $faq)
    {
        if ($faq->enabled == true)
            return new FAQResource($faq);
        else
           return new JsonResponse([], 200);
    }
}
