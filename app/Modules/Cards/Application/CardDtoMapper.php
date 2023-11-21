<?php

declare(strict_types=1);

namespace App\Modules\Cards\Application;

use App\Modules\Cards\App\Dto\CardDto;

class CardDtoMapper
{
    private const KEY_ID = 'id';
    private const KEY_NAME = 'name';
    private const KEY_POWER = 'power';
    private const KEY_IMAGE = 'image';

    public function fromArray(array $card): CardDto
    {
        return new CardDto(
            id: (int)$card[self::KEY_ID],
            name: $card[self::KEY_NAME],
            power: (int)$card[self::KEY_POWER],
            image: $card[self::KEY_IMAGE],
        );
    }
    
    public function toArray(CardDto $card): array
    {
        return [
            self::KEY_ID => $card->id,
            self::KEY_NAME => $card->name,
            self::KEY_POWER => $card->power,
            self::KEY_IMAGE => $card->image,
        ];
    }
}