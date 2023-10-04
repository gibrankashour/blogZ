<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
//use Spatie\Permission\Contracts\Role;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SearchableTrait;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'mobile',
        'status',
        'bio',
        'receive_email',
        'user_image',
        'cover_image',
        'email_verified_at',
    ];

    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.username' => 8,
            'users.email' => 8,
        ]
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }
    public function approvedPosts() {
        return $this->hasMany(Post::class)->where('status', 1);
    }
    public function pendingPosts() {
        return $this->hasMany(Post::class)->where('status', 0);
    }
    public function status() {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }
    public function isAdmin() {
        return $this->admin === 1 ? true : false;
    }
}
