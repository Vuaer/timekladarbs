<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meme;

class Searched_meme extends Model
{
    use HasFactory;
    
    public function meme()
    {
        $this->belongsTo(Meme::class);
    }
}
