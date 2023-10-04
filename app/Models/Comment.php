<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Comment extends Model
{
    use HasFactory,SearchableTrait;

    protected $guarded = [];
    protected $searchable = [
        'columns' => [
            'comments.comment' => 10
        ]
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function replies() {
        return $this->hasMany(Comment::class, 'comment_id')->where('status', 1)->orderBy('created_at', 'desc');
    }
    public function adminReplies() {
        return $this->hasMany(Comment::class, 'comment_id')->orderBy('created_at', 'desc');
    }

    public function status() {
        return $this->status == 1 ? 'Approved' : 'Disapproved';
    }
}
