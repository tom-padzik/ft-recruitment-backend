<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Mappers;

use App\Modules\Cards\Api\Collections\CardsDtoCollection;
use App\Modules\Cards\Api\Contracts\CardsFacadeInterface;
use App\Modules\Cards\Api\Dto\CardDto;
use App\Modules\Duel\Application\Dto\DuelDto;
use App\Modules\Duel\Models\Duel;

use function array_key_exists;

readonly class DuelDtoMapper
{
    public function __construct(
        private CardsFacadeInterface $cardsFacade,
    ) {
    }

    public function fromDuel(Duel $duel): DuelDto
    {
        return new DuelDto(
            id: (int)$duel->getKey(),
            round: $duel->round,
            playerId: (int)$duel->player->getKey(),
            userId: (int)$duel->player->user->getKey(),
            userName: $duel->player->user->name,
            opponentName: $duel->opponent_name,
            userCardsCollection: $this->setCards(
                allIds: $duel->player->cards_ids,
                playedIds: $duel->player_played_cards_ids,
            ),
            userPlayedCardsCollection: $this->cardsFacade->findIds(
                $duel->player_played_cards_ids,
            ),
            opponentCardsCollection: $this->setCards(
                allIds: $duel->opponent_cards_ids,
                playedIds: $duel->opponent_played_cards_ids,
            ),
            opponentPlayedCardsCollection: $this->cardsFacade->findIds(
                $duel->opponent_played_cards_ids,
            ),
            createdAt: $duel->created_at,
            finishedAt: $duel->finished_at,
        );
    }

    private function setCards(array $allIds, array $playedIds): CardsDtoCollection
    {
        $cards = $this->cardsFacade->findIds($allIds);
        $this->setInactiveCards(cards: $cards, inactiveIds: $playedIds);

        return $cards;
    }

    private function setInactiveCards(
        CardsDtoCollection $cards,
        array $inactiveIds,
    ): void {
        $cards->each(
            fn(CardDto $card) => $card->setActive(
                active: array_key_exists($card->id, $inactiveIds),
            ),
        );
    }
}
