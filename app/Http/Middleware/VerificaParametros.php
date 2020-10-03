<?php

namespace App\Http\Middleware;

use Closure;

class VerificaParametros{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $statusCodeBadRequest = 400;

        if(count($request->route()->parameters()) != 2){
            return response()->json([
                'success'   => false,
                'message'   => 'Parâmetros inválidos',
                'data'      => []
            ], $statusCodeBadRequest);
        }

        return $next($request);
    }
}
