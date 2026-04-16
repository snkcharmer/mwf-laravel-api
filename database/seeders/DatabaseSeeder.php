<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin@gmail.com',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => UserRoleEnum::Admin->value,
        ]);
    }
}
