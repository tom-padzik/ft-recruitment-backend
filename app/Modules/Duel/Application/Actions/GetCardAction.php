<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Actions;

use App\Models\User;
use App\Modules\Cards\Api\Contracts\CardsFacadeInterface;
use App\Modules\Cards\Api\Dto\CardDto;
use App\Modules\Duel\Api\Contracts\DuelUserFacadeInterface;
use App\Modules\Duel\Api\Exceptions\MaximumNumberCardsReachedException;

readonly class GetCardAction
{
    public function __construct(
        private DuelUserFacadeInterface $duelUserFacade,
        private CardsFacadeInterface $cardsFacade,
        private DuelPlayerSaveAction $saveAction,
    ) {
    }

    public function execute(User $user): void
    {
        if (false === $this->duelUserFacade->canGetNewCards($user)) {
            throw new MaximumNumberCardsReachedException();
        }

        $this->addRandomCard(user: $user);
    }

    private function addRandomCard(User $user): void
    {
        /** @var CardDto $card */
        $card = $this->cardsFacade->all()
            ->whereNotIn('id', $user->duelPlayer->cards_ids)
            ->random();

        $player = $user->duelPlayer;
        $ids = $player->cards_ids;
        $ids[] = $card->getKey();
        $player->cards_ids = $ids;

        $this->saveAction->execute($player);
    }
}