<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Library_meme;

class Library extends Model
{
    use HasFactory;
    public function library_meme($meme_id)
    {
        $library_meme = Library_meme::where('meme_id',$meme_id)->first();
        return $library_meme;
    }
    public function library_memes($meme_id)
    {
        $library_meme = Library_meme::where('meme_id',$meme_id)->first();
        if($library_meme != NULL)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
