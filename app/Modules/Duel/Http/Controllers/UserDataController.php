<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cards\App\Contracts\CardsFacadeInterface;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    public function __construct(
        private readonly CardsFacadeInterface $cardsFacade,
    ) {
    }

    public function userData(Request $request): array
    {
        // @todo: get user cards Ids,
        $cardsIds = [1,3,7,8,11,12]; 
        return [
            'id' => (int)$request->user()->getKey(),
            'username' => $request->user()->name,
            'level' => 1,
            'level_points' => '40/100',
            'cards' => $this->cardsFacade->findIds($cardsIds)->toArray(),
            'new_card_allowed' => true,
        ];
    }
}