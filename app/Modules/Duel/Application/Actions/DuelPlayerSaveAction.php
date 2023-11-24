<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Actions;

use App\Modules\Duel\Models\DuelPlayer;

class DuelPlayerSaveAction
{
    public function execute(DuelPlayer $player): void
    {
        $player->save();
    }
}