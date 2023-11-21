<?php

declare(strict_types=1);

namespace App\Modules\Cards\App\Dto;

readonly class CardDto
{
    public function __construct(
        public int $id,
        public string $name,
        public int $power,
        public string $image,
    ) {
    }
}