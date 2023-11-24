<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Actions;

use App\Modules\Cards\Api\Contracts\CardsFacadeInterface;
use App\Modules\Cards\Api\Dto\CardDto;
use App\Modules\Duel\Api\Contracts\DuelFacadeInterface;
use App\Modules\Duel\Api\Exceptions\CardAlreadyUsedException;
use App\Modules\Duel\Http\Requests\DuelActionRequest;
use App\Modules\Duel\Models\Duel;
use Illuminate\Support\Facades\Config;

use function in_array;

readonly class DuelActionAction
{
    public function __construct(
        private DuelFacadeInterface $duelFacade,
        private CardsFacadeInterface $cardsFacade,
        private DuelSaveAction $saveAction,
    ) {
    }

    public function execute(DuelActionRequest $request): ?CardDto
    {
        $maxRound = Config::get('game.definitions.levels.rounds');
        
        $duelDto = $this->duelFacade
            ->findActiveForUserOrFail(user: $request->user());
        
        $duel = $this->duelFacade->findOrFail($duelDto->getKey());
        
        $this->serPlayerCard(duel: $duel, cardId: $request->id);
        $opponentCard = $this->setOpponentCard(duel: $duel);
        $nextRound = $duel->round + 1;
        if($nextRound <= $maxRound) {
            $duel->round = $nextRound;
        }
        $this->saveAction->execute($duel);

        if($nextRound > Config::get('game.definitions.levels.rounds')) {
            $this->duelFacade->finishDuel($duel);
        }


        return $opponentCard;
    }

    private function serPlayerCard(Duel $duel, int $cardId): void
    {
        if (true === in_array(
                $cardId,
                $duel->player_played_cards_ids,
                false,
            )
        ) {
            throw new CardAlreadyUsedException(cardId: $cardId);
        }

        $playerCardsIds = $duel->player_played_cards_ids;
        $playerCardsIds[] = $cardId;
        $duel->player_played_cards_ids = $playerCardsIds;
    }

    private function setOpponentCard(Duel $duel): CardDto
    {
        $opponentCardsIds = $duel->opponent_played_cards_ids;
        $opponentCard = $this->opponentCard(duel: $duel);
        $opponentCardsIds[] = $opponentCard->getKey();
        $duel->opponent_played_cards_ids = $opponentCardsIds;

        return $opponentCard;
    }

    private function opponentCard(Duel $duel): CardDto
    {
        return $this->cardsFacade->findIds($duel->opponent_cards_ids)
            ->whereNotIn('id', $duel->opponent_played_cards_ids)
            ->random();
    }
}