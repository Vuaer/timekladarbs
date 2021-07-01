<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\App;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Session\Session;

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
        $locale = $request->getLocale();

        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
            config(['app.locale' => $locale]);
        }
        else {
            $availableLangs = ['lv', 'en'];
            $userLangs = preg_split('/,|;/', $request->server('HTTP_ACCEPT_LANGUAGE'));

            foreach ($availableLangs as $lang) {
                if(in_array($lang, $userLangs)) {
                    App::setLocale($lang);
                    session('locale', $lang);
                    break;
                }
            }
        }
        //config(['app.locale' => $locale]);
        //App::setLocale(session($locale));
        
        return $next($request);
    }

       
        
       
    
}
