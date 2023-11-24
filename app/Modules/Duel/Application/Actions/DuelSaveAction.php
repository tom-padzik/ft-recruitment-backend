<?php

declare(strict_types=1);

namespace App\Modules\Duel\Application\Actions;

use App\Modules\Duel\Models\Duel;

class DuelSaveAction
{
    public function execute(Duel $duel): void
    {
        $duel->save();
    }
}