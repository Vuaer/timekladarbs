<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\App;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle(Request $request, Closure $next)
    {
//    $has= session()->exists("reizes");
//    echo "has locale ->";
//    echo $has;
//    echo " <-has locale";
//
//        if($has==NULL)
//        {
//                 session(["reizes",0]);   
//                 echo "set to 0 !sesion dont have reizes";
//        }
//
//    $langArr = array("en", "lv");
//    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
//        $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
//    } else {
//        $languages[0] = "en";
//    }
//    $reizes =session()->pull('reizes');
//    if ($reizes==0) {
//        session()->increment('reizes');
//        if (in_array($languages[0], $langArr))
//        {
//            App::setLocale($languages[0]);
//        }
//        else
//        {
//            App::setLocale('en');
//        }
//    } else {
//        echo session('locale');
//        echo " <-locale";
//        App::setLocale(session('locale'));  
//        
//    }
//    //echo "$languages[0]";
//    echo " reizes -> ";
//    echo session()->pull('reizes');
//    echo " <-reizes";
//    //echo session()->has('reizes');
        App::setLocale(session('locale'));
        //dd(session('locale'));
        return $next($request);
    }
}
