<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Meme;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function memes(){
        return $this->hasMany(Meme::class);
    }

    public function isModer()
    {
        return ($this->role == 'moderator' || $this->role == 'administrator');
    }

    public function isAdmin()
    {
        return ($this->role == 'administrator');
    }
     public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function dislikes()
    {
        return $this->hasMany(Dislike::class);
    }
}
