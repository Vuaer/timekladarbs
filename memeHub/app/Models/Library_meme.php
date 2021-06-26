<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meme;

class Library_meme extends Model
{
    use HasFactory;

    public function meme()
    {
        return $this->belongsTo(Meme::class,'meme_id');
    }
}
