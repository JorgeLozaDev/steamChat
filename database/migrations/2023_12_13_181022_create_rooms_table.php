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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->boolean("is_active")->default(true);
            $table->unsignedBigInteger("id_player");
            $table->unsignedBigInteger("id_game");
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("update_at")->useCurrent()->useCurrentOnUpdate();

            $table->foreign("id_player")->references("id")->on("player_users");
            $table->foreign("id_game")->references("id")->on("games");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
