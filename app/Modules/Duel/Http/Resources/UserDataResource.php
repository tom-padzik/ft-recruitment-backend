<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Resources;

use App\Modules\Cards\App\Contracts\CardsFacadeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class UserDataResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        // @todo: get user cards Ids,
        $cardsIds = [1,3,7,8,11,12];
        
        
        return [
            'id' => (int)$request->user()->getKey(),
            'username' => $request->user()->name,
            'level' => 1,
            'level_points' => '40/100',
            'cards' => App::make(CardsFacadeInterface::class)
                ->findIds(ids: $cardsIds),
            'new_card_allowed' => true,
        ];

    }
}