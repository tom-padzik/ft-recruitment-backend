<?php

declare(strict_types=1);

namespace App\Modules\Duel\Api\Contracts;

use App\Models\User;
use App\Modules\Cards\Api\Collections\CardsDtoCollection;

interface DuelUserFacadeInterface
{
    public function canGetNewCards(User $user): bool;

    public function level(User $user): int;

    public function userCardsIds(User $user): array;

    public function userCards(User $user): CardsDtoCollection;

    public function levelCards(User $user): int;

    public function points(User $user): int;

    public function nextLevelPoints(User $user): int;

}