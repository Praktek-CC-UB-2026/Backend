<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
        ]);

        Task::create([
            'user_id' => $user->id,
            'title' => 'Belajar Laravel',
            'description' => 'Mempelajari dasar-dasar framework Laravel',
            'status' => 'in_progress',
        ]);

        Task::create([
            'user_id' => $user->id,
            'title' => 'Belajar Vue.js',
            'description' => 'Membuat frontend dengan Vue.js 3',
            'status' => 'pending',
        ]);

        Task::create([
            'user_id' => $user->id,
            'title' => 'Setup Docker',
            'description' => 'Containerisasi aplikasi dengan Docker',
            'status' => 'pending',
        ]);
    }
}
