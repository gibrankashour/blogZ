<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{
    public function areaChart($time) {
        if($time == 'week' )
        {
            $timeBefore = strtotime('-6day', time());
            $i = $timeBefore;        
            $days = [];
            $labels = [];
            $postsCount =[];
            $commentsCount =[];
            while($i < strtotime('+1day', time())) {
                $days[] = date('l',$i);
                $i = strtotime('+1day', $i);
            }
            
            // البحث يكون من بداية الشهر من السنهة السابقة
            $timeSuitedForSearch = date('Y-m-d',mktime(0,0,0,date('m',$timeBefore),date('d',$timeBefore),date('Y',$timeBefore))) . ' 00:00:00';
            $posts = Post::select(DB::raw("count(*) as count"), DB::raw("extract(day from created_at) as day"), DB::raw("extract(month from created_at) as month"), DB::raw("extract(year from created_at) as year"))
                        ->where('post_type', 'post')
                        ->where('created_at', '>', $timeSuitedForSearch)
                        ->groupBy('day', 'month', 'year')->orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('day', 'asc')->get();
                        
            $comments = Comment::select(DB::raw("count(*) as count"), DB::raw("extract(day from created_at) as day") , DB::raw("extract(month from created_at) as month"), DB::raw("extract(year from created_at) as year"))
                        ->where('created_at', '>', $timeSuitedForSearch)
                        ->groupBy('day', 'month', 'year')->orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('day', 'asc')->get();
                        // dd($posts);
            /* قد يكون هناك اشهر لا تحوي على بوستات او كومنتات لذلك لا تأتي من قاعدة البيانات
            لحل هذه المشكلة نعطي أولا قيم صفرية لعدد البوستات والكومنتات لكل شهر ثم نتأكد 
            من القيم الحقيقية التي أتت من قاعدة البيانات */
            $i = 0;
            $test =[];
            foreach($days as $day) {
                $postsCount[$i] = 0; 
                $commentsCount[$i] = 0; 
                foreach($posts as $post) {                    
                    if($day == date('l', strtotime($post->year.'-'.$post->month.'-'.$post->day)) ) {
                        $postsCount[$i] = $post->count;
                    }
                }
                foreach($comments as $comment) {
                    if($day == date('l', strtotime($comment->year.'-'.$comment->month.'-'.$comment->day)) ) {
                        $commentsCount[$i] = $comment->count;
                    }
                }
                $i++;
            }
            $labels = $days; 
        }
        elseif($time == 'month' )
        {
            $timeBefore = strtotime('-29day', time());
            $i = $timeBefore;        
            $days = [];
            $labels = [];
            $postsCount =[];
            $commentsCount =[];
            while($i < strtotime('+1day', time())) {
                $days[] = date('d',$i);
                $labels[] = date('d',$i) . '/' . date('M',$i);
                $i = strtotime('+1day', $i);
            }
            
            // البحث يكون من بداية الشهر من السنهة السابقة
            $timeSuitedForSearch = date('Y-m-d',mktime(0,0,0,date('m',$timeBefore),date('d',$timeBefore),date('Y',$timeBefore))) . ' 00:00:00';
            $posts = Post::select(DB::raw("count(*) as count"), DB::raw("extract(day from created_at) as day"), DB::raw("extract(month from created_at) as month"), DB::raw("extract(year from created_at) as year"))
                        ->where('post_type', 'post')
                        ->where('created_at', '>', $timeSuitedForSearch)
                        ->groupBy('day', 'month', 'year')->orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('day', 'asc')->get();
                       
            $comments = Comment::select(DB::raw("count(*) as count"), DB::raw("extract(day from created_at) as day") , DB::raw("extract(month from created_at) as month"), DB::raw("extract(year from created_at) as year"))
                        ->where('created_at', '>', $timeSuitedForSearch)
                        ->groupBy('day', 'month', 'year')->orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('day', 'asc')->get();
            
            /* قد يكون هناك اشهر لا تحوي على بوستات او كومنتات لذلك لا تأتي من قاعدة البيانات
            لحل هذه المشكلة نعطي أولا قيم صفرية لعدد البوستات والكومنتات لكل شهر ثم نتأكد 
            من القيم الحقيقية التي أتت من قاعدة البيانات */
            $i = 0;
            $test =[];
            foreach($days as $day) {
                $postsCount[$i] = 0; 
                $commentsCount[$i] = 0; 
                foreach($posts as $post) {                    
                    if($day == $post->day ) {
                        $postsCount[$i] = $post->count;
                    }
                }
                foreach($comments as $comment) {
                    if($day == $comment->day ) {
                        $commentsCount[$i] = $comment->count;
                    }
                }
                $i++;
            }
             
        }
        elseif($time == 'year')
        {
            /* مثلا اذا كنت بالشهر الخامس فانا بدي الإحصائيات من الشهر السادس
            من السنة السابقة لهي طرحت سنه وزدت شهر */
            $timeBefore = strtotime('-1year +1month', time());
            $i = $timeBefore;        
            $months = [];
            $labels = [];
            $postsCount =[];
            $commentsCount =[];
            while($i < strtotime('+1month', time())) {
                $months[] = date('m',$i);
                $labels[] = date('Y',$i) . '/' . date('m',$i);
                $i = strtotime('+1month', $i);
            }
            
            // البحث يكون من بداية الشهر من السنهة السابقة
            $timeSuitedForSearch = date('Y-m-d',mktime(0,0,0,date('m',$timeBefore),1,date('Y',$timeBefore))) . ' 00:00:00';
            $posts = Post::select(DB::raw("count(*) as count"), DB::raw("extract(month from created_at) as month"), DB::raw("extract(year from created_at) as year"))
                        ->where('post_type', 'post')
                        ->where('created_at', '>', $timeSuitedForSearch)
                        ->groupBy('month', 'year')->orderBy('year', 'asc')->orderBy('month', 'asc')->get();
            $comments = Comment::select(DB::raw("count(*) as count"), DB::raw("extract(month from created_at) as month"), DB::raw("extract(year from created_at) as year"))
                        ->where('created_at', '>', $timeSuitedForSearch)
                        ->groupBy('month', 'year')->orderBy('year', 'asc')->orderBy('month', 'asc')->get();
                        // dd($posts);
            /* قد يكون هناك اشهر لا تحوي على بوستات او كومنتات لذلك لا تأتي من قاعدة البيانات
            لحل هذه المشكلة نعطي أولا قيم صفرية لعدد البوستات والكومنتات لكل شهر ثم نتأكد 
            من القيم الحقيقية التي أتت من قاعدة البيانات */
            $i = 0;
            foreach($months as $month) {
                $postsCount[$i] = 0; 
                $commentsCount[$i] = 0; 
                foreach($posts as $post) {
                    if($month == $post->month) {
                        $postsCount[$i] = $post->count;
                    }
                }
                foreach($comments as $comment) {
                    if($month == $comment->month) {
                        $commentsCount[$i] = $comment->count;
                    }
                }
                $i++;
            }

        }// endif $time == year
        
        $chart['labels'] = $labels;
        $chart['datasets'][0]['label'] = 'Posts';
        $chart['datasets'][0]['data'] = $postsCount;

        $chart['datasets'][1]['label'] = 'Comments';
        $chart['datasets'][1]['data'] = $commentsCount;
        
        return response()->json($chart);      
    }

    
    public function pieChart() {
        $chart['labels']= [];
        $chart['data']= [];
        $categories = Category::withCount('posts')->orderBy('posts_count', 'desc')->limit(3)->get();
        foreach($categories as $category) {
            $chart['labels'][] = $category->name;
            $chart['data'][] = $category->posts_count;
        }
        return response()->json($chart);
    } 
}
