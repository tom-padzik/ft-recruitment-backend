<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Duel\Api\Contracts\DuelFacadeInterface;
use App\Modules\Duel\Http\Resources\UserDataResource;
use Illuminate\Http\Request;

class DuelUserDataController extends Controller
{
    public function __construct(
        private readonly DuelFacadeInterface $duelFacade,
    ) {
    }

    public function userData(Request $request): UserDataResource
    {
        $this->duelFacade->createPlayerIfNotExists(user: $request->user());

        return new UserDataResource($request);
    }
}