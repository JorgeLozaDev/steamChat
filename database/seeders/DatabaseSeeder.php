<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\PlayerUser::factory(10)->create();
        \App\Models\Rooms_Table::factory(10)->create();
        \App\Models\Room_User::factory(10)->create();
        \App\Models\Games::factory(10)->create();
        \App\Models\Chat_Room::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
