<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Duel\Http\Resources\UserDataResource;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    public function userData(Request $request): UserDataResource
    {
        return new UserDataResource($request);
    }
}