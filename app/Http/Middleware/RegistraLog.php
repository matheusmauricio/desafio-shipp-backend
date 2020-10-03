<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class RegistraLog{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $conteudoReponse        = json_decode($response->getContent());
        $dataHoraRequest        = "Data/Hora do request: " . date('d/m/Y H:i:s') . "\n";
        $rotaAcessada           = "Rota Acessada: " . $request->path() . "\n";
        $statusCode             = "Status Code: ". $response->status() . "\n";
        $registrosRetornados    = "Registros retornados: " . count($conteudoReponse->data) . "\n";
        $latitude               = "Latitude: $request->latitude \n" ?? "\n";
        $longitude              = "Longitude: $request->longitude \n " ?? "\n";

        $mensagemInicialFinal   = "***INFORMAÇÕES DO REQUEST*** \n";

        $resultadoRequest = "\n $mensagemInicialFinal" . $dataHoraRequest . $rotaAcessada . $statusCode . $registrosRetornados . $latitude . $longitude . $mensagemInicialFinal;

        Log::info($resultadoRequest);
    }

}
