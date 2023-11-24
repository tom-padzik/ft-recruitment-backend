<?php

declare(strict_types=1);

namespace App\Modules\Duel\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int         $round
 * @property array       $player_played_cards_ids
 * @property array       $opponent_played_cards_ids
 * @property array       $opponent_cards_ids,
 * @property string      $opponent_name
 * @property DuelPlayer  $player
 * @property Carbon|null $created_at
 * @property Carbon|null $finished_at
 */
class Duel extends Model
{
    protected $casts
        = [
            'player_played_cards_ids' => 'array',
            'opponent_played_cards_ids' => 'array',
            'opponent_cards_ids' => 'array',
            'finished_at' => 'datetime',
        ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(DuelPlayer::class, 'duel_player_id');
    }
}