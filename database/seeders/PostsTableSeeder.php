<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use illuminate\support\Str;
//use illuminate\Support\Collection;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $posts = [];
        $categories = Category::select('id')->get();
        $user = User::select('id')->where('id', '>', 2)->get();

        for ($i = 0; $i < 250; $i++) {

            $post_date = date('Y-m-d H:i:s', (time() - 47430688) + rand(0, 47430000));
            $post_title = $faker->sentence(mt_rand(3, 6), true);


            $posts[] = [
                'title'         => $post_title,
                'slug'          => Str::slug($post_title),
                'description'   => $faker->paragraph(),
                'status'        => rand(0, 1),
                'comment_able'  => rand(0, 1),
                'user_id'       => $user->random()->id,
                'category_id'   => $categories->random()->id,
                'created_at'    => $post_date,
                'updated_at'    => $post_date,

            ];
        }

        $chunks = array_chunk($posts, 25);
        foreach ($chunks as $chunk) {
            Post::insert($chunk);
        }
    }
}
