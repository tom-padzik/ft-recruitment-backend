<?php

declare(strict_types=1);

namespace App\Modules\Duel\Api\Exceptions;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

use function sprintf;

class CardAlreadyUsedException extends RuntimeException
{
    public function __construct(int $cardId)
    {
        parent::__construct(
            sprintf(
                'Card ID: %s was already used in this duel',
                $cardId,
            ),
            Response::HTTP_UNPROCESSABLE_ENTITY,
        );
    }

}