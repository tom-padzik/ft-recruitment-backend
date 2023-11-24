<?php

declare(strict_types=1);

namespace App\Modules\Cards\Api\Dto;

class CardDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $power,
        public readonly string $image,
        public ?bool $active = null,
    ) {
    }

    public function getKey(): int
    {
        return $this->id;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

}