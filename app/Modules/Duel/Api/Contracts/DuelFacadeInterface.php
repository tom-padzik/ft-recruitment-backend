<?php

declare(strict_types=1);

namespace App\Modules\Duel\Api\Contracts;

use App\Models\User;
use App\Modules\Duel\Application\Collections\DuelDtoCollection;
use App\Modules\Duel\Application\Dto\DuelDto;
use App\Modules\Duel\Models\Duel;

interface DuelFacadeInterface
{
    public function findActiveForUser(User $user): ?DuelDto;

    public function findActiveForUserOrFail(User $user): DuelDto;

    public function findLastFinishedForUser(User $user): ?DuelDto;

    public function findAllFinishedForUser(User $user): DuelDtoCollection;

    public function createPlayerIfNotExists(User $user): void;

    public function finishDuel(Duel $duel): DuelDto;

    public function isWon(DuelDto $duelDto): bool;

    public function findOrFail(int $id): Duel;
}