<?php

namespace App\Http\Middleware;

use Closure;

class JsonMiddleware
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
        if ($request->isJson())
        {
            return $next($request);
        }else{
            $content = $request->header('content-type');

            $retorno['description'] ='O "Content-Type" HTTP “'.$content.'” não é suportado. Falha no carregamento da mídia';

            return response()->json([$retorno], 203);
        }
    }
}
