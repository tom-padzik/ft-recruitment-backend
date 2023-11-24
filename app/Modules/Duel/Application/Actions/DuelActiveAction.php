<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Actions;

use App\Models\User;
use App\Modules\Duel\Api\Contracts\DuelFacadeInterface;
use App\Modules\Duel\Application\Dto\DuelDto;

readonly class DuelActiveAction
{
    
    public function __construct(
        private DuelFacadeInterface $duelFacade,
    ) {
    }

    public function execute(User $user): ?DuelDto
    {
        return $this->duelFacade->findActiveForUser(user: $user)
            ?? $this->duelFacade->findLastFinishedForUser(user: $user);
    }
}