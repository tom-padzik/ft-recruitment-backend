<?php

declare(strict_types=1);

namespace App\Modules\Cards\Application;

use App\Modules\Cards\App\Collection\CardsCollection;
use App\Modules\Cards\App\Dto\CardDto;
use Illuminate\Support\Facades\Config;

class CardsFacade
{
    private CardsCollection $cards;
    
    public function __construct()
    {
        $this->cardsToCollection();
    }

    public function exists($id): bool
    {
        return null !== $this->find(id: $id);
    }
    
    
    public function find($id): ?CardDto
    {
        return $this->cards->firstWhere('id','=',$id);
    }
    
    public function all(): CardsCollection
    {
        return $this->cards;
    }
    
    private function cardsToCollection(): void
    {
        $cards = Config::get('game.cards');
        $mapper = new CardDtoMapper();
        $this->cards = new CardsCollection();
        foreach ($cards as $card) {
            $this->cards->push($mapper->fromArray(card: $card));
        }
    }
}