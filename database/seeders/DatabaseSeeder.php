<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use InvalidArgumentException;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = config('app.initial_admin');
        $email = $admin['email'];
        $password = $admin['password'];

        if (! $email && ! $password) {
            return;
        }

        if (
            ! is_string($email) ||
            ! filter_var($email, FILTER_VALIDATE_EMAIL) ||
            ! is_string($password) ||
            strlen($password) < 16
        ) {
            throw new InvalidArgumentException(
                'Set a valid INITIAL_ADMIN_EMAIL and an INITIAL_ADMIN_PASSWORD of at least 16 characters.'
            );
        }

        User::query()->firstOrCreate(
            ['email' => $email],
            [
                'name' => $admin['name'],
                'password' => $password,
                'role' => UserRole::SuperAdmin,
            ]
        );
    }
}
