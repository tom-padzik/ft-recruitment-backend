<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Resources;

use App\Modules\Cards\Api\Contracts\CardsFacadeInterface;
use App\Modules\Duel\Application\Dto\DuelDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class DuelActiveResource extends JsonResource
{
    public static $wrap = false;

    /** @var ?DuelDto $resource */
    public $resource;

    public function toArray(Request $request): array
    {
        if(null === $this->resource) {
            return [];
        }
        
        $cardsFacade = App::make(CardsFacadeInterface::class);

        return [
            'id' => $this->resource->getKey(),
            'round' => $this->resource->round,
            'your_points' => $cardsFacade
                ->sumCardsPower($this->resource->userPlayedCardsCollection),
            'opponent_points' => $cardsFacade
                ->sumCardsPower($this->resource->opponentPlayedCardsCollection),
            'status' => null === $this->resource->finishedAt ? 'active' : 'finished',
            'cards' => $this->resource->userCardsCollection->values(),
        ];
    }
}