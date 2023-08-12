<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserResource;
use App\Http\Resources\API\UserCollection;

class UserController extends Controller
{
    public function index(User $user)
    {
        return new UserCollection($user->latest()->get());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }
}
