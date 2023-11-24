<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Actions;

use App\Models\User;
use App\Modules\Cards\Api\Contracts\CardsFacadeInterface;
use App\Modules\Duel\Application\Dto\DuelDto;
use App\Modules\Duel\Application\Mappers\DuelDtoMapper;
use App\Modules\Duel\Models\Duel;
use App\Modules\Duel\Models\DuelPlayer;

use Illuminate\Support\Facades\Config;

use function fake;
use function sprintf;

readonly class DuelCreateAction
{
    public function __construct(
        private DuelPlayerCreateAction $playerCreateAction,
        private DuelSaveAction $duelSaveAction,
        private DuelDtoMapper $mapper,
        private CardsFacadeInterface $cardsFacade,
    ) {
    }

    public function execute(User $user): DuelDto
    {
        $duelPlayer = $this->getPlayer(user: $user);
        // @todo - select cards for computer

        $duel = new Duel();
        $duel->player()->associate($duelPlayer);
        $duel->round = 1;
        $duel->finished_at = null;
        $duel->opponent_played_cards_ids = [];
        $duel->opponent_cards_ids = $this->opponentCardsIds(player: $duelPlayer);
        $duel->player_played_cards_ids = [];
        $duel->opponent_name = fake()->name();

        $this->duelSaveAction->execute($duel);

        return $this->mapper->fromDuel($duel);
    }

    private function getPlayer(User $user): DuelPlayer
    {
        return $user->duelPlayer ?? $this->playerCreateAction->execute($user);
    }
    
    private function opponentCardsIds(DuelPlayer $player): array
    {
        $count = Config::get(
            sprintf('game.definitions.levels.max_cards.%s',$player->level)
        );
        return $this->cardsFacade->all()->random($count)->pluck('id')->values()->toArray(); 
    }
}