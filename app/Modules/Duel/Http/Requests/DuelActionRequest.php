<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Requests;

use App\Modules\Duel\Application\Validation\Rules\CardIdExistsRule;
use Illuminate\Foundation\Http\FormRequest;

//{
//    "id": 1,
//    "name": "Sergio Donputamadre",
//    "power": 101,
//    "image": "card-1.jpg",
//    "clickable": true
//}

class DuelActionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', new CardIdExistsRule()],
        ];
    }
}