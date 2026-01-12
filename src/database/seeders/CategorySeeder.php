<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 1; $i <= 500; $i++) {
            // Generate nama kategori yang lebih realistis menggunakan Faker
            $name = $faker->unique()->words(rand(1, 3), true); // Kata unik, 1-3 kata

            $data[] = [
                'name' => ucwords($name), // Kapitalisasi awal kata
                'slug' => Str::slug($name) . '-' . $i, // Slug dari nama fake + index untuk unik
                'is_active' => $faker->boolean(80), // 80% chance aktif
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ];
        }

        // Insert sekaligus dalam batch untuk efisiensi (sudah optimal)
        Category::insert($data);
    }
}
