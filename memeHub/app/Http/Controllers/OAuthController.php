<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use App\Models\User;


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
        $user=Socialite::driver('facebook')->user();
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
        }
        Auth::login($user);
    }
}
