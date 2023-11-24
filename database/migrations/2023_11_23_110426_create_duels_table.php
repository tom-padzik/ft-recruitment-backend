<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('duels', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('duel_player_id');
            $table->integer('round')->default(1);
            $table->string('player_played_cards_ids')->default('[]');
            $table->string('opponent_played_cards_ids')->default('[]');
            $table->string('opponent_cards_ids')->default('[]');
            $table->string('opponent_name');
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();

            $table->foreign('duel_player_id')
                ->references('id')->on('duel_players');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duels');
    }
};
