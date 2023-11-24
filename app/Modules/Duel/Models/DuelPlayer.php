<?php

declare(strict_types=1);

namespace App\Modules\Duel\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property User             $user
 * @property array            $cards_ids
 * @property int              $level
 * @property int              $points
 * @property Collection<Duel> $duels
 */
class DuelPlayer extends Model
{
    protected $casts
        = [
            'cards_ids' => 'array',
        ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function duels(): HasMany
    {
        return $this->hasMany(Duel::class);
    }
}