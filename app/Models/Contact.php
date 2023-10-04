<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Contact extends Model
{
    use HasFactory,SearchableTrait;

    protected $guarded = [];
    protected $searchable = [
        'columns' => [            
            'contacts.name' => 10,
            'contacts.title' => 9,
            'contacts.message' => 8,
        ]
    ];

    public function status() {
        return $this->status == 1 ? 'Repalyed' : 'Didn\'t repalyed';
    }

    public function replay() {
        return $this->hasOne(Replay::class);
    }
}
