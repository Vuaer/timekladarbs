<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Library;



class OAuthController extends Controller
{
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function handleGoogleCallback()
    {
        $user=Socialite::driver('google')->user();
        $this->createUser($user);
        return redirect()->route('meme.index');
    }

    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    
    public function handleFacebookCallback()
    {
        $user=Socialite::driver('facebook')->stateless()->user();
        $this->createUser($user);
        return redirect()->route('meme.index');
    }
    
    public function createUser($data)
    {
        $user=User::where('email','=',$data->email)->first();
        if(!$user){
            $user=new User;
            $user->email=$data->email;
            $user->name=$data->name;
            $user->provider_id=$data->id;
            $user->save();
            $library = new Library;
            $library->user_id = $user->id;
            $library->save();
        }
        Auth::login($user);
    }
}
