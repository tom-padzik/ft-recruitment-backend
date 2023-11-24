<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Actions;

use App\Models\User;
use App\Modules\Duel\Models\DuelPlayer;

readonly class DuelPlayerCreateAction
{
    public function __construct(
        private DuelPlayerSaveAction $playerSaveAction,
    ) {
    }

    public function execute(User $user): DuelPlayer
    {
        return $this->preparePlayer(user: $user);
    }

    private function preparePlayer(User $user): DuelPlayer
    {
        if (null !== $user->duelPlayer) {
            return $user->duelPlayer;
        }

        $player = new DuelPlayer();
        $player->cards_ids = [];
        $player->level = 1;
        $player->user()->associate($user);

        $this->playerSaveAction->execute($player);
        
        $user->refresh();

        return $player;
    }
}