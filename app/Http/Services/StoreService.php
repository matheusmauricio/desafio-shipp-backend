<?php

namespace App\Http\Services;

use App\Http\Resources\StoreResource;
use App\Repositories\StoreRepository;
use Exception;
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

            DB::beginTransaction();

            $dados = $this->formatarDadosLoja($dados);

            $idLojaCadastrada = $this->repository->inserirLoja($dados);

            $lojaCadastrada = $this->repository->detalharLoja($idLojaCadastrada);

            DB::commit();

            return [
                'success'   => true,
                'message'   => 'Loja inserida com sucesso.',
                'data'      => StoreResource::make($lojaCadastrada)
            ];

        } catch(\Exception $e){
            DB::rollBack();

            return [
                'success'   => false,
                'message'   => 'Falha ao inserir a loja. Erro: ' . $e->getMessage(),
                'data'      => []
            ];
        }
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
