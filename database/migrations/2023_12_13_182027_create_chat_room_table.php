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
        Schema::create('chat_room', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_player_sender");
            $table->unsignedBigInteger("id_room");
            $table->string('message');
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("update_at")->useCurrent()->useCurrentOnUpdate();
            $table->foreign("id_player_sender")->references("id")->on("player_users");
            $table->foreign("id_room")->references("id")->on("rooms");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_room');
    }
};
