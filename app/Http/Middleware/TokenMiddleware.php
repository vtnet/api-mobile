<?php

namespace App\Http\Middleware;

use Closure;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('x-auth-token')==NULL){
            $retorno['description'] ='Token não autorizado';
            return response()->json($retorno, 203);
        }
        return $next($request);
    }
}
