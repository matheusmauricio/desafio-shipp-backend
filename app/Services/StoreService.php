<?php

namespace App\Services;

use App\Http\Resources\StoreResource;
use App\Repositories\StoreRepository;
use Illuminate\Support\Facades\DB;

class StoreService
{
    protected $repository;
    protected $addressService;

    public function __construct(StoreRepository $repository, AddressService $addressService){
        $this->repository       = $repository;
        $this->addressService   = $addressService;
    }

    public function inserirLoja($dados){
        try{
            // Obs.: Como a ideia do projeto é inserir os dados na base a partir de um arquivo csv estático, estou levando em consideração que os dados e o header sempre estarão no mesmo formato/padrão, portanto não estou realizando nenhuma validação dos dados recebidos.

            // DB::beginTransaction();

            // $dados = $this->formatarDadosLoja($dados);

            $idLojaCadastrada = $this->repository->inserirLoja($dados);

            // $lojaCadastrada = $this->repository->detalharLoja($idLojaCadastrada);

            // DB::commit();

            return [
                'success'   => true,
                'message'   => 'Loja inserida com sucesso.',
                'data'      => []
            ];

        } catch(\Exception $e){
            // DB::rollBack();

            return [
                'success'   => false,
                'message'   => 'Falha ao inserir a loja. Erro: ' . $e->getMessage(),
                'data'      => []
            ];
        }
    }

    public function buscarLojas($latitude, $longitude){
        try{
            // O regex foi feito utilizando número com vírgula pois o parâmetro está sendo passado na rota, e quando utiliza ponto na rota dá erro. A conversão da vírgula para o ponto e de string pra float está sendo feita logo abaixo

            $regexLatitudeLongitude = '/^(\+|-)?(?:90(?:(?:\,0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\,[0-9]{1,7})?))$/';

            if(!preg_match($regexLatitudeLongitude, $latitude)){
                return [
                    'success'   => false,
                    'message'   => 'Latitude inválida.',
                    'data'      => []
                ];
            }

            if(!preg_match($regexLatitudeLongitude, $longitude)){
                return [
                    'success'   => false,
                    'message'   => 'Longitude inválida.',
                    'data'      => []
                ];
            }

            $latitude   = floatval(str_replace(",", ".", $latitude));
            $longitude  = floatval(str_replace(",", ".", $longitude));

            $distanciaMaxima = floatval(env('DISTANCIA_MAXIMA'));

            $lojas = $this->repository->listarTodasLojas();
            $arrayLojasProximas = [];

            foreach($lojas as $loja){
                $distancia = $this->calcularDistancia($latitude, $longitude, $loja->latitude, $loja->longitude);

                if($distancia <= $distanciaMaxima){
                    $loja->distance = $distancia;

                    // Monta as informações relativas ao endereço
                    $loja = $this->montarDadosEndereco($loja);

                    array_push($arrayLojasProximas, $loja);
                } else {
                    continue;
                }
            }

            // Reordena o array pela distância mais próxima
            usort($arrayLojasProximas, [$this, "ordenarPelaDistancia"]);

            return [
                'success'   => true,
                'message'   => 'Lojas listadas com sucesso.',
                'data'      => StoreResource::collection($arrayLojasProximas)
            ];
        } catch(\Exception $e){

            return [
                'success'   => false,
                'message'   => 'Falha ao buscar loja. Erro: ' . $e->getMessage(),
                'data'      => []
            ];
        }
    }

    public function ordenarPelaDistancia($a, $b){
        return ($a->distance <=> $b->distance);
    }

    public function montarDadosEndereco($loja){
        $dadosEndereco = [
            'idAddress' => $loja->id_address
        ];

        $endereco = $this->addressService->detalharEndereco($dadosEndereco);

        if(!$endereco['success']){
            return $endereco;
        }

        $endereco['data'] = collect($endereco['data']);

        $loja->address = $endereco['data'];

        return $loja;
    }

    public function calcularDistancia($latitude1, $longitude1, $latitude2, $longitude2) {
        $raioTerra  = env('RAIO_TERRA');
        $latitude1  = deg2rad($latitude1);
        $latitude2  = deg2rad($latitude2);
        $longitude1 = deg2rad($longitude1);
        $longitude2 = deg2rad($longitude2);

        $distancia = ($raioTerra * acos( cos( $latitude1 ) * cos( $latitude2 ) * cos( $longitude2 - $longitude1 ) + sin( $latitude1 ) * sin($latitude2) ) );
        $distancia = number_format($distancia, 2, '.', '');

        return floatval($distancia);
    }

    public function formatarDadosLoja($dados){
        return [
            'idLoja'            => $dados['idLoja'] ?? null,
            'idAddress'         => $dados['idAddress'] ?? null,
            'licenseNumber'     => trim($dados['licenseNumber']) ?? null,
            'operationType'     => trim($dados['operationType']) ?? null,
            'establishmentType' => trim($dados['establishmentType']) ?? null,
            'entityName'        => trim($dados['entityName']) ?? null,
            'dbaName'           => trim($dados['dbaName']) ?? null,
        ];
    }
}
