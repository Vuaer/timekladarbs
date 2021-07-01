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
        echo session('locale');
        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
        }
        
        config(['app.locale' => $locale]);
        //App::setLocale(session($locale));
        
        return $next($request);
    }

       
        
       
    
}
