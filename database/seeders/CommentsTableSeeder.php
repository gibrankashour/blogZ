<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker      = Factory::create();
        $comments    = [];
        $users       = collect(User::where('id', '>', 2)->get()->modelKeys());
        $posts       = collect(Post::wherePostType('post')->whereStatus(1)->whereCommentAble(1)->get());

        for($i = 0 ; $i < 1500; $i++) {

            $selected_post = $posts->random();
            $post_date = $selected_post->created_at->timestamp;
            $current_date = Carbon::now()->timestamp;

            $comments[] = [
                'name' => $faker->name,
                'email' => $faker->email,
                'ip_address' => $faker->ipv4,
                'comment' => $faker->paragraph(2, true),
                'status' => rand(0, 1),
                'post_id' => $selected_post->id,
                'user_id' => $users->random(),
                'created_at' => date('Y-m-d H:i:s', rand($post_date, $current_date)),
                'updated_at' => date('Y-m-d H:i:s', rand($post_date, $current_date)),
            ];

        }


        $chunks = array_chunk($comments, 500);
        foreach ($chunks as $chunk) {
            Comment::insert($chunk);
        }

        // ------------- previous_comments ----------- //

        $previous_comments = Comment::whereStatus('1')->where('comment_id', null)->get();


        for($i = 0 ; $i < 500; $i++) {

            $previous_comment = $previous_comments->random();

            $selected_post = $previous_comment->post_id;
            $comment_date  = $previous_comment->created_at->timestamp;
            $current_date  = Carbon::now()->timestamp;

            $comments[] = [
                'name' => $faker->name,
                'email' => $faker->email,
                'ip_address' => $faker->ipv4,
                'comment' => $faker->paragraph(2, true),
                'status' => rand(0, 1),
                'post_id' => $selected_post,
                'user_id' => $users->random(),
                'comment_id' => $previous_comment->id,
                'created_at' => date('Y-m-d H:i:s', rand($comment_date, $current_date)),
                'updated_at' => date('Y-m-d H:i:s', rand($comment_date, $current_date)),
            ];

        }


        $chunks = array_chunk($comments, 100);
        foreach ($chunks as $chunk) {
            Comment::insert($chunk);
        }

    }
}
