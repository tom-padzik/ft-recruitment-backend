<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Resources;

use App\Modules\Duel\Api\Contracts\DuelFacadeInterface;
use App\Modules\Duel\Application\Dto\DuelDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class UserDuelDtoResource extends JsonResource
{
    public static $wrap = false;

    /** @var DuelDto $resource */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'player_name' => $this->resource->userName,
            'opponent_name' => $this->resource->opponentName,
            'won' => $this->won(),
        ];
    }

    private function won(): int
    {
        return App::make(DuelFacadeInterface::class)->isWon(duelDto: $this->resource)
            ? 1 : 0;
    }

}