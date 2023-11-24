<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Duel\Api\Contracts\DuelFacadeInterface;
use App\Modules\Duel\Application\Actions\DuelActionAction;
use App\Modules\Duel\Application\Actions\DuelActiveAction;
use App\Modules\Duel\Application\Actions\DuelStartAction;
use App\Modules\Duel\Application\Actions\GetCardAction;
use App\Modules\Duel\Http\Requests\DuelActionRequest;
use App\Modules\Duel\Http\Resources\DuelActiveResource;
use App\Modules\Duel\Http\Resources\UserDuelDtoResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;


class DuelsController extends Controller
{

    public function __construct(
        private readonly DuelFacadeInterface $duelFacade,
        private readonly GetCardAction $getCardAction,
        private readonly DuelStartAction $duelStartAction,
        private readonly DuelActionAction $actionAction,
        private readonly DuelActiveAction $activeAction,
    ) {
    }

    public function index(Request $request): Collection
    {
        $duels = $this->duelFacade->findAllFinishedForUser(
            user: $request->user(),
        );
        if ($duels->isEmpty()) {
            return $duels;
        }
        return UserDuelDtoResource::collection($duels)->collection;
    }

    public function cards(Request $request): JsonResponse
    {
        $this->getCardAction->execute(user: $request->user());
        return new JsonResponse();
    }

    public function active(Request $request): DuelActiveResource|array
    {
        return new DuelActiveResource(
            $this->activeAction->execute($request->user())
        );
    }

    //START THE DUEL
    public function duel(Request $request): JsonResponse
    {
        $this->duelStartAction->execute(user: $request->user());
        return Response::json();
    }

    public function action(DuelActionRequest $request): JsonResponse
    {
        return Response::json(
            $this->actionAction->execute(request: $request),
        );
    }
}