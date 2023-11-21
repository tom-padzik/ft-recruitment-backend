<?php

declare(strict_types=1);

namespace App\Modules\Cards\App\Contracts;

use App\Modules\Cards\App\Collection\CardsCollection;
use App\Modules\Cards\App\Dto\CardDto;

interface CardsFacadeInterface
{
    public function exists($id): bool;
    public function find($id): ?CardDto;
    public function all(): CardsCollection;
}