<?php

declare(strict_types=1);

namespace App\Modules\Cards\Api\Collections;

use App\Application\TypedCollection\TypedCollectionAbstract;
use App\Modules\Cards\Api\Dto\CardDto;

class CardsDtoCollection extends TypedCollectionAbstract
{
    protected function validateType(mixed $item): bool
    {
        return $item instanceof CardDto;
    }
}