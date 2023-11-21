<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Duel\Http\Resources\DuelUserDataResource;
use Illuminate\Http\Request;

class DuelUserDataController extends Controller
{
    public function userData(Request $request): DuelUserDataResource
    {
        return new DuelUserDataResource($request);
    }
}