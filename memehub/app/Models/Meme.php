<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Library_meme;

use App\Models\Comment;
use App\Models\Meme_keyword;
use App\Models\Like;
use App\Models\Dislike;

class Meme extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function memesInLibraries(){
        return $this->belongsTo(Library_meme::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function dislikes()
    {
        return $this->hasMany(Dislike::class);
    }
    public function keywords()
    {
        return $this->hasMany(Keyword::class);
    }
}
