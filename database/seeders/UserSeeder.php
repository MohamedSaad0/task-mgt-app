<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::insert([
            [
                'name' => 'Johnny Depp',
                'email' => 'john@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('secret'),
                'remember_token' => Str::random(10),
                'is_admin' => '1'
            ],
            [
                'name' => 'Chris Hemsworth',
                'email' => 'chris@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('secret'),
                'remember_token' => Str::random(10),
                'is_admin' => '0' 
            ],
            [
                'name' => 'Morgan Freeman',
                'email' => 'morgan@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('secret'),
                'remember_token' => Str::random(10),
                'is_admin' => '0'
            ],
            [
                'name' => 'Tom Hanks',
                'email' => 'Tom@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('secret'),
                'remember_token' => Str::random(10),
                'is_admin' => '0'
            ],
        ]);
    }
}
