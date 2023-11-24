<?php

namespace Tests\Unit\Modules\Cards\Application;

use App\Modules\Cards\Api\Contracts\CardsFacadeInterface;
use App\Modules\Cards\Api\Dto\CardDto;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Config;
use Tests\CreatesApplication;

class CardsFacadeTest extends TestCase
{
    use CreatesApplication;

    public CardsFacadeInterface $cardsFacade;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cardsFacade = App::make(CardsFacadeInterface::class);
    }

    public function testCardExists(): void
    {
        $this->assertTrue($this->cardsFacade->exists(id: 1));
    }

    public function testCardNotExists(): void
    {
        $this->assertFalse($this->cardsFacade->exists(id: -1));
    }

    public function testCardFound(): void
    {
        $this->assertInstanceOf(
            CardDto::class,
            $this->cardsFacade->find(id: 1),
        );
    }

    public function testCardNotFound(): void
    {
        $this->assertNull(
            $this->cardsFacade->find(id: -1),
        );
    }

    public function testAllCards(): void
    {
        $all = $this->cardsFacade->all();
        $fromConfig = Config::get('game.cards');

        $this->assertEquals(
            count($fromConfig),
            $all->count(),
        );
    }

    public function testFindIds(): void
    {
        $ids = [1,2];
        
        $cards = $this->cardsFacade->findIds(ids: $ids);
        $this->assertEquals(2, $cards->count());
        
        /** @var CardDto $card */
        $card = $cards->firstWhere('id', '=', '1');
        $this->assertEquals(1, $card->getKey());
        
        $card = $cards->firstWhere('id', '=', '2');
        $this->assertEquals(2, $card->getKey());
    }

    public function testSumPower(): void
    {
        $ids = [1,2,3,4];
        
        $cards = $this->cardsFacade->findIds(ids:$ids);
        $sumPower = 0;
        /** @var CardDto $card */
        foreach ($cards as $card) {
            $sumPower += $card->power;
        }
        
        $this->assertEquals(
            $sumPower,
            $this->cardsFacade->sumCardsPower(cards: $cards)
        );
        
        $this->assertEquals(
            $sumPower,
            $this->cardsFacade->sumIdsPower(ids: $ids)
        );
    }
}
