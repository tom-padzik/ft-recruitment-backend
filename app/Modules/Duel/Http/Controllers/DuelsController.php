<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Duel\Http\Requests\DuelActionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;


class DuelsController extends Controller
{

    public function index(Request $request): array
    {
        return [
            [
                'id' => 1,
                'player_name' => 'Jan Kowalski',
                'opponent_name' => 'Piotr Nowak',
                'won' => 0,
            ],
            [
                'id' => 2,
                'player_name' => 'Jan Kowalski',
                'opponent_name' => 'Tomasz Kaczyński',
                'won' => 1,
            ],
            [
                'id' => 3,
                'player_name' => 'Jan Kowalski',
                'opponent_name' => 'Agnieszka Tomczak',
                'won' => 1,
            ],
            [
                'id' => 4,
                'player_name' => 'Jan Kowalski',
                'opponent_name' => 'Michał Bladowski',
                'won' => 1,
            ],
        ];
    }

    public function active(Request $request): array
    {
        return [
            'round' => 4,
            'your_points' => 260,
            'opponent_points' => 100,
            'status' => 'active',
            'cards' => Config::get('game.cards'),
        ];
    }

    //START THE DUEL
    public function duel(Request $request): JsonResponse
    {
        return Response::json();
    }

    public function action(DuelActionRequest $request)
    {
        return Response::json();
    }
}