<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => UserRole::SuperAdmin,
        ]);
    }
}
