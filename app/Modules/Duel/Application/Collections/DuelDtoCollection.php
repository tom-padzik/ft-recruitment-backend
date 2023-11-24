<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Collections;

use App\Application\TypedCollection\TypedCollectionAbstract;
use App\Modules\Duel\Application\Dto\DuelDto;

class DuelDtoCollection extends TypedCollectionAbstract
{

    protected function validateType(mixed $item): bool
    {
        return $item instanceof DuelDto;
    }
}