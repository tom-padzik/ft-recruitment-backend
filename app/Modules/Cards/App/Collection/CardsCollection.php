<?php

declare(strict_types=1);

namespace App\Modules\Cards\App\Collection;

use App\Application\TypedCollection\TypedCollectionAbstract;
use App\Modules\Cards\App\Dto\CardDto;

class CardsCollection extends TypedCollectionAbstract
{

    protected function validateType(mixed $item): bool
    {
        return $item instanceof CardDto;
    }
}