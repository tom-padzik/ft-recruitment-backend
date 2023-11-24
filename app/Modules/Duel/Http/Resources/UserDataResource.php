<?php

declare(strict_types=1);

namespace App\Modules\Duel\Http\Resources;

use App\Models\User;
use App\Modules\Duel\Api\Contracts\DuelUserFacadeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class UserDataResource extends JsonResource
{
    public static $wrap = false;

    private DuelUserFacadeInterface $duelUserFacade;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->duelUserFacade = App::make(DuelUserFacadeInterface::class);
    }


    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $request->user();

        return [
            'id' => (int)$user->getKey(),
            'username' => $user->name,
            'level' => $this->duelUserFacade->level(user: $user),
            'level_points' => $this->duelUserFacade->points(user: $user),
            'cards' => $this->duelUserFacade->userCards(user: $user)->toArray(),
            'new_card_allowed' => $this->duelUserFacade
                ->canGetNewCards(user: $user),
        ];
    }
}