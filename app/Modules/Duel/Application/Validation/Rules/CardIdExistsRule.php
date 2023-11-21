<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Validation\Rules;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

use function sprintf;

class CardIdExistsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $card = Arr::first(
            Config::get('game.cards'),
            static function ($card) use ($value) {
                return (int)$card['id'] === $value;
            }
        );

        if(!empty($card)) {
            $fail(sprintf('Card ID: %s don\'t exists.', $value));
        }
    }
}