<?php

namespace App\Http\Middleware;

use App\Http\Model\TelefoneModel;
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
            $retorno['error'] ='Token não autorizado';
            return response()->json($retorno, 203);
        }

        $token = filter_var($request->header('x-auth-token'), FILTER_SANITIZE_STRING);

        $rs=TelefoneModel::where('token', $token)->first();

        if(!$rs)
            return response()->json(['error'=>'Token não autorizado'], 203);

        // $a = $next($request);
        // dd($next($request));
        return $next($request);
    }
}
