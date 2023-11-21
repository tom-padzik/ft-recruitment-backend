<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Resources;

use App\Modules\Cards\App\Collection\CardsCollection;
use App\Modules\Cards\App\Contracts\CardsFacadeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class DuelUserDataResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (int)$request->user()->getKey(),
            'username' => $request->user()->name,
            'level' => $this->level(),
            'level_points' => $this->levelPoints(),
            'cards' => $this->userCards()->toArray(),
            'new_card_allowed' => $this->areNewCardsAllowed(),
        ];
    }

    private function level(): int
    {
        // @todo
        return 1;
    }

    private function levelPoints(): string
    {
        // @todo
        return '40/100';
    }

    private function userCards(): CardsCollection
    {
        return App::make(CardsFacadeInterface::class)
            ->findIds(ids: $this->userCardsIds());
    }


    private function areNewCardsAllowed(): bool
    {
        // @todo
        return true;
    }


    private function userCardsIds(): array
    {
        // @todo: get real user cards Ids,
        return [1, 3, 7, 8, 11, 12];
    }
}