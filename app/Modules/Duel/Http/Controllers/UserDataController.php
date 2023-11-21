<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class UserDataController extends Controller
{

    public function userData(Request $request): array
    {
        return [
            'id' => (int)$request->user()->getKey(),
            'username' => $request->user()->name,
            'level' => 1,
            'level_points' => '40/100',
            'cards' => Config::get('game.cards'),
            'new_card_allowed' => true,
        ];
    }
}