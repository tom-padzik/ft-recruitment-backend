<?php

declare(strict_types=1);

namespace App\Modules\Duel\Api\Exceptions;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class MaximumNumberCardsReachedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(
            'Maximum number of cards has been reached',
            Response::HTTP_UNPROCESSABLE_ENTITY,
        );
    }
}