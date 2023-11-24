<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Dto;

use App\Modules\Cards\Api\Collections\CardsDtoCollection;
use Carbon\Carbon;

class DuelDto
{

    public function __construct(
        public readonly int $id,
        public readonly int $round,
        public readonly int $playerId,
        public readonly int $userId,
        public readonly string $userName,
        public readonly string $opponentName,
        public CardsDtoCollection $userCardsCollection,
        public CardsDtoCollection $userPlayedCardsCollection,
        public CardsDtoCollection $opponentCardsCollection,
        public CardsDtoCollection $opponentPlayedCardsCollection,
        public Carbon $createdAt,
        public ?Carbon $finishedAt = null,     
    ) {
    }

    public function getKey(): int
    {
        return $this->id;
    }
}