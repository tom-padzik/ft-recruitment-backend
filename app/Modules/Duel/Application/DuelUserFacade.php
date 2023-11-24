<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application;

use App\Models\User;
use App\Modules\Cards\Api\Collections\CardsDtoCollection;
use App\Modules\Cards\Api\Contracts\CardsFacadeInterface;
use App\Modules\Duel\Api\Contracts\DuelUserFacadeInterface;
use Illuminate\Support\Facades\Config;

use function count;
use function sprintf;

readonly class DuelUserFacade implements DuelUserFacadeInterface
{

    public function __construct(
        private CardsFacadeInterface $cardsFacade,
    ) {
    }

    public function canGetNewCards(User $user): bool
    {
        return count($this->userCardsIds(user: $user))
            < $this->levelCards(user: $user);
    }

    public function level(User $user): int
    {
        return $user->duelPlayer->level;
    }


    public function userCardsIds(User $user): array
    {
        return $user->duelPlayer->cards_ids;
    }

    public function userCards(User $user): CardsDtoCollection
    {
        return $this->cardsFacade->findIds(
            ids: $this->userCardsIds(user: $user),
        );
    }

    public function levelCards(User $user): int
    {
        return (int)Config::get(
            sprintf(
                'game.definitions.levels.max_cards.%s',
                $this->level(user: $user),
            ),
        );
    }

    public function points(User $user): int
    {
        return $user->duelPlayer->points;
    }

    public function nextLevelPoints(User $user): int
    {
        return (int)Config::get(
            sprintf(
                'game.definitions.levels.next_level_points.%s',
                $this->level(user: $user),
            ),
        );
    }
}