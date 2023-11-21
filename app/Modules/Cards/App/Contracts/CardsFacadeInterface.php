<?php

declare(strict_types=1);

namespace App\Modules\Cards\App\Contracts;

use App\Modules\Cards\App\Collection\CardsCollection;
use App\Modules\Cards\App\Dto\CardDto;

interface CardsFacadeInterface
{
    public function exists(int $id): bool;
    public function find(int $id): ?CardDto;
    public function all(): CardsCollection;
    public function findIds(array $ids): CardsCollection;
}