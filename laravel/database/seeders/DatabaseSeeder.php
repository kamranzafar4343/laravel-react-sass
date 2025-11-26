<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'kamran',
            'email' => 'kamran@mezan.com',
            'password' => 'kamran@mezan'
        ]);

        Feature::create([
            'image' => 'https://img.icons8.com/color/200/plus.png',
            'name' => 'Calculate Sum',
            'description' => 'calculate sum of two numbers',
            'required_credits' => 1,
            'active' => true,
        ]);
        Feature::create([
            'image' => 'https://img.icons8.com/color/200/minus.png',
            'name' => 'Calculate Difference',
            'description' => 'calculate difference of two numbers',
            'required_credits' => 3,
            'active' => true,
        ]);

        Package::create([
            'name' => 'Basic',
            'price' => 5,
            'credits' => 20,
        ]);
        
        Package::create([
            'name' => 'Silver',
            'price' => 20,
            'credits' => 100,
        ]);
        
        Package::create([
            'name' => 'Gold',
            'price' => 100,
            'credits' => 1000,
        ]);
    }
}
