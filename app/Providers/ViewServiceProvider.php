<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        view()->composer('*', function($view){

            /* if(cache()->has('categories')){ 
                cache()->forget('categories');
            } */

            // Start recent_posts Section
            if(!cache()->has('recent_posts')){
                $recent_posts = Post::with(['media'])->whereHas('category', function($query) {
                    $query->where('status', 1);
                })->where('post_type', 'post')->where('status', 1)->orderBy('updated_at', 'desc')->limit(5)->get();

                cache()->remember('recent_posts', 3600, function() use ($recent_posts) {
                    return $recent_posts;
                });
            }

            $recent_posts = cache()->get('recent_posts');
            // End recent_posts Section


            // Start recent_comments Section
            if(!cache()->has('recent_comments')){
                $recent_comments = Comment::with(['post'])
                    ->where('status', 1)->orderBy('updated_at', 'desc')->limit(5)->get();

                cache()->remember('recent_comments', 3600, function() use ($recent_comments) {
                    return $recent_comments;
                });
            }

            $recent_comments = cache()->get('recent_comments');
            // End recent_comments Section

            // Start categories Section
            if(!cache()->has('categories')){
                $categories = Category::where('status', 1)
                    ->withCount('posts')->orderBy('posts_count', 'DESC')
                    ->limit(6)->get();

                cache()->remember('categories', 3600, function() use ($categories) {
                    return $categories;
                });
            }

            $categories = cache()->get('categories');
            // End categories Section

            // Start archives Section
            if(!cache()->has('archives')){
                $archives = Post::select(DB::raw("Year(created_at) as year"), DB::raw("Month(created_at) as month"))
                // previous code show the following error in PostgreSQL
                // SQLSTATE[42883]: Undefined function: 7 ERROR: function year(timestamp without time zone) does not exist
                // $archives = Post::select(DB::raw("extract(year from created_at) as year"), DB::raw("extract(month from created_at) as month"))
                    ->where('post_type', 'post')->where('status', 1)->groupBy('year', 'month')
                    ->orderBy('year', 'desc')->orderBy('month', 'desc')->get();


                cache()->remember('archives', 3600, function() use ($archives) {
                    return $archives;
                });
            }

            $archives = cache()->get('archives');
            // End archives Section



            $view->with([
                'recent_posts'      => $recent_posts,
                'recent_comments'   => $recent_comments,
                'categories'        => $categories,
                'archives'          => $archives,
            ]);
        });

    }
}
