<?php

namespace App\Http\Controllers\API;

use App\Models\AdminUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserCollection;

class AdminUserController extends Controller
{
    public function index(AdminUser $admin_user)
    {
        return response()->json([            
            'data' => $request->admin_user(), 
        ]);
        //return new AdminUserCollection($admin_user->latest()->get());
    }
}
