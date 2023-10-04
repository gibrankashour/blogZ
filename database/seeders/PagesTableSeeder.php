<?php

namespace Database\Seeders;

use App\Models\Post;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Post::create([
            'title'         => 'About Us',
            'slug'          => 'about_us',
            'description'   => $faker->paragraph,
            'status'        => 1,
            'comment_able'  => 0,
            'post_type'     => 'page',
            'user_id'       => 8,
            'category_id'   => 1,
        ]);

        Post::create([
            'title'         => 'Our Vision',
            'slug'          => 'our_vision',
            'description'   => $faker->paragraph,
            'status'        => 1,
            'comment_able'  => 0,
            'post_type'     => 'page',
            'user_id'       => 8,
            'category_id'   => 1,
        ]);
    }
}
