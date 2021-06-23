<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meme;

class Keyword extends Model
{
    use HasFactory;
    
    public function memes()
    {
        return $this->belongsToMany(Meme::class);
    }
}
