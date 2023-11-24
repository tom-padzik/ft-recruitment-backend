<?php

declare(strict_types=1);

namespace App\Modules\Cards\Api\Contracts;

use App\Modules\Cards\Api\Collections\CardsDtoCollection;
use App\Modules\Cards\Api\Dto\CardDto;

interface CardsFacadeInterface
{
    public function exists(int $id): bool;

    public function find(int $id): ?CardDto;

    public function all(): CardsDtoCollection;

    public function findIds(array $ids): CardsDtoCollection;

    public function sumCardsPower(CardsDtoCollection $cards): int;

    public function sumIdsPower(array $ids): int;
}