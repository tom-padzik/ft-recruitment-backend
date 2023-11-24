<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application;

use App\Models\User;
use App\Modules\Cards\Api\Contracts\CardsFacadeInterface;
use App\Modules\Duel\Api\Contracts\DuelFacadeInterface;
use App\Modules\Duel\Application\Actions\DuelPlayerCreateAction;
use App\Modules\Duel\Application\Actions\DuelPlayerSaveAction;
use App\Modules\Duel\Application\Actions\DuelSaveAction;
use App\Modules\Duel\Application\Collections\DuelDtoCollection;
use App\Modules\Duel\Application\Dto\DuelDto;
use App\Modules\Duel\Application\Mappers\DuelDtoMapper;
use App\Modules\Duel\Models\Duel;
use App\Modules\Duel\Models\DuelPlayer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;


use function sprintf;

readonly class DuelFacade implements DuelFacadeInterface
{
    public function __construct(
        private DuelDtoMapper $duelDtoMapper,
        private CardsFacadeInterface $cardsFacade,
        private DuelSaveAction $duelSaveAction,
        private DuelPlayerSaveAction $playerSaveAction,
    ) {
    }

    public function findActiveForUser(User $user): ?DuelDto
    {
        /** @var Duel|null $duel */
        $duel = $this->forUserQuery($user)
            ->whereNull('finished_at')
            ->first();
        
        return null === $duel
            ? null
            : $this->duelDtoMapper->fromDuel(duel: $duel);
    }
    
    public function findActiveForUserOrFail(User $user): DuelDto
    {
        /** @var Duel $duel */
        $duel = $this->forUserQuery($user)
            ->whereNull('finished_at')
            ->firstOrFail();

        return $this->duelDtoMapper->fromDuel(duel: $duel);
    }

    public function findLastFinishedForUser(User $user): ?DuelDto
    {
        /** @var Duel|null $duel */
        $duel = $this->forUserQuery(user: $user)
            ->whereNotNull('finished_at')
            ->orderBy('finished_at','desc')
            ->first();
        
        if(null === $duel) {
            return null;
        }
        
        return $this->duelDtoMapper->fromDuel(duel: $duel);
    }

    public function findAllFinishedForUser(User $user): DuelDtoCollection
    {
        $duels = $this->forUserQuery(user: $user)
            ->whereNotNull('finished_at')
            ->get();

        $collection = new DuelDtoCollection();

        if (false === $duels->isEmpty()) {
            foreach ($duels as $duel) {
                $collection->push(
                    $this->duelDtoMapper->fromDuel(duel: $duel),
                );
            }
        }

        return $collection;
    }

    public function createPlayerIfNotExists(User $user): void
    {
        if (null !== $user->duelPlayer) {
            return;
        }
        App::make(DuelPlayerCreateAction::class)
            ->execute(user: $user);
    }

    public function finishDuel(Duel $duel): DuelDto
    {
        $duelDto = $this->duelDtoMapper->fromDuel($duel);
        if(null !== $duel->finished_at) {
            return $duelDto;
        }
        $duel->finished_at = Carbon::now();
        $this->duelSaveAction->execute(duel: $duel);
        
        if ($this->isWon(duelDto: $duelDto)) {
            $player = $duel->player;
            $player->points += Config::get('game.definitions.won_points');
            
            $this->setPlayerLevel($player);
            
            $this->playerSaveAction->execute(player: $player);
        }
        
        return $this->duelDtoMapper->fromDuel(duel: $duel); 
    }
    
    public function isWon(DuelDto $duelDto): bool
    {
        return  $this->cardsFacade->sumCardsPower(
            cards: $duelDto->userPlayedCardsCollection
            )
            > $this->cardsFacade->sumCardsPower(
                cards: $duelDto->opponentPlayedCardsCollection
            );
    }
    
    public function findOrFail(int $id): Duel
    {
        return Duel::query()->findOrFail($id);
    }

    private function forUserQuery(User $user): Builder
    {
        return Duel::query()
            ->where(
                'duel_player_id',
                '=',
                (int)$user->duelPlayer?->getKey(),
            );
    }

    private function setPlayerLevel(DuelPlayer $player): void
    {
        if(
            $player->level < Config::get('game.definitions.levels.max_level')
            && $player->points >= Config::get(
                sprintf(
                    'game.definitions.levels.next_level_points.%s',$player->level)
            )
        ) {
            $player->level++;
        }
    }
}