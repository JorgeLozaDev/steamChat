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
        Schema::create('room__user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_player");
            $table->unsignedBigInteger("id_room");
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("updated_at")->useCurrent()->useCurrentOnUpdate();
            $table->foreign("id_player")->references("id")->on("player_users");
            $table->foreign("id_room")->references("id")->on("rooms");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room__user');
    }
};
