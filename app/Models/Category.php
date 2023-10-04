<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Category extends Model
{
    use HasFactory,SearchableTrait;
    
    protected $guarded = [];
    protected $searchable = [
        'columns' => [
            'categories.name' => 10
        ]
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }
    public function status() {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }
    
}
