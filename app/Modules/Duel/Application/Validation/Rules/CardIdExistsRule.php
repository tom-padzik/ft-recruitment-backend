<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Validation\Rules;
use App\Modules\Cards\App\Contracts\CardsFacadeInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\App;

use function sprintf;

class CardIdExistsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (
            false === App::make(CardsFacadeInterface::class)
                ->exists(id: (int)$value)
        ) {
            $fail(sprintf('Card ID: %s don\'t exists.', $value));
        }
    }
}