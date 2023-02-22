<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Idea;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Category::factory()->create(['name' => 'Techology']);
        Category::factory()->create(['name' => 'Financial']);
        Category::factory()->create(['name' => 'Polithic']);
        Category::factory()->create(['name' => 'Health']);
        Idea::factory(30)->create();
    }
}
