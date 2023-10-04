<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Post extends Model
{
    use HasFactory,SearchableTrait;
    
    protected $guarded = [];
    
    protected $searchable = [
        'columns' => [
            'posts.title' => 10,
            'posts.description' => 9
        ]
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function media() {
        return $this->hasMany(PostMedia::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function parentComments() {
        return $this->hasMany(Comment::class)->whereNull('comment_id')->orderBy('created_at', 'desc');
    }

    public function approvedComments() {
        return $this->hasMany(Comment::class)->where('status', 1);
    }

    public function approvedParentComments() {
        return $this->hasMany(Comment::class)->where('status', 1)->whereNull('comment_id')->orderBy('created_at', 'desc');
    }
    public function status() {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }
}
