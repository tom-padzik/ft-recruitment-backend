<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Actions;

use App\Models\User;
use App\Modules\Duel\Api\Contracts\DuelFacadeInterface;
use App\Modules\Duel\Application\Dto\DuelDto;

readonly class DuelStartAction
{

    public function __construct(
        private DuelFacadeInterface $duelFacade,
        private DuelCreateAction $duelCreateAction,
    ) {
    }

    public function execute(User $user): DuelDto
    {
        return $this->duelFacade->findActiveForUser($user)
            ?? $this->duelCreateAction->execute($user);
    }

}