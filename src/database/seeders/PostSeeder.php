<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title'   => 'Post Latihan Laravel Docker',
            'slug'    => Str::slug('Post Latihan Laravel Docker'),
            'content' => 'Ini adalah contoh konten untuk latihan database Laravel.',
            'status'  => 'published',
        ]);
    }
}
