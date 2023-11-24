<?php

declare(strict_types=1);

namespace App\Modules\Cards\Application;

use App\Modules\Cards\Api\Collections\CardsDtoCollection;
use App\Modules\Cards\Api\Contracts\CardsFacadeInterface;
use App\Modules\Cards\Api\Dto\CardDto;
use Illuminate\Support\Facades\Config;

class CardsFacade implements CardsFacadeInterface
{
    private CardsDtoCollection $cards;

    public function __construct()
    {
        $this->cardsToCollection();
    }

    public function exists(int $id): bool
    {
        return null !== $this->find(id: $id);
    }

    public function find(int $id): ?CardDto
    {
        return $this->cloneCards()->firstWhere('id', '=', $id);
    }

    public function all(): CardsDtoCollection
    {
        return $this->cloneCards();
    }

    private function cardsToCollection(): void
    {
        $cards = Config::get('game.cards');
        $mapper = new CardDtoMapper();
        $this->cards = new CardsDtoCollection();
        foreach ($cards as $card) {
            $this->cards->push($mapper->fromArray(card: $card));
        }
    }

    public function findIds(array $ids): CardsDtoCollection
    {
        return $this->cloneCards()->whereIn('id', $ids);
    }

    public function sumCardsPower(CardsDtoCollection $cards): int
    {
        return $cards->sum(fn(CardDto $card) => $card->power);
    }

    public function sumIdsPower(array $ids): int
    {
        return $this->sumCardsPower($this->findIds($ids));
    }

    private function cloneCards(): CardsDtoCollection
    {
        return clone $this->cards;
    }
}