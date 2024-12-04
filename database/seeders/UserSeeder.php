<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'wassim',
            'email' => 'ahmedwassim317@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->image()->create([
            'path' => fake()->image(),
        ]);

        User::factory(10)
            ->has(
                Tweet::factory()
                    ->has(Comment::factory()->count(4))
                    ->count(3)
            )
            ->create();
    }
}
