<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\PlayerUser::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\PlayerUser::factory(10)->create();
        \App\Models\Rooms_Table::factory(10)->create();
        \App\Models\Room_User::factory(10)->create();
        \App\Models\Games::factory(10)->create();
        \App\Models\Chat_Room::factory(10)->create();

    }
}
