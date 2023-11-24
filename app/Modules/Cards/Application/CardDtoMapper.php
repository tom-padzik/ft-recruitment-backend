<?php

declare(strict_types=1);

namespace App\Modules\Cards\Application;

use App\Modules\Cards\Api\Dto\CardDto;

class CardDtoMapper
{
    public function fromArray(array $card): CardDto
    {
        return new CardDto(
            id: (int)$card['id'],
            name: $card['name'],
            power: (int)$card['power'],
            image: $card['image'],
        );
    }
}