<?php

namespace App\Services;

use App\Http\Resources\AddressResource;
use App\Repositories\AddressRepository;
use Illuminate\Support\Facades\DB;

class AddressService
{
    protected $repository;

    public function __construct(AddressRepository $repository){
        $this->repository = $repository;
    }


    public function inserirEndereco($dados){
        try{
            // Obs.: Como a ideia do projeto é inserir os dados na base a partir de um arquivo csv estático, estou levando em consideração que os dados e o header sempre estarão no mesmo formato/padrão, portanto não estou realizando nenhuma validação dos dados recebidos.

            // DB::beginTransaction();

            // $dados = $this->formatarDadosEndereco($dados);

            $idEnderecoCadastrado = $this->repository->inserirEndereco($dados);

            // $enderecoCadastrado = $this->repository->detalharEndereco($idEnderecoCadastrado);

            // DB::commit();

            return [
                'success'   => true,
                'message'   => 'Endereço inserido com sucesso.',
                'data'      => ['idAddress' => $idEnderecoCadastrado]
            ];

        } catch(\Exception $e){
            // DB::rollBack();

            return [
                'success'   => false,
                'message'   => 'Falha ao inserir o endereço. Erro: ' . $e->getMessage(),
                'data'      => []
            ];
        }
    }

    public function detalharEndereco($dados){
        try{
            $endereco = $this->repository->detalharEndereco($dados['idAddress']);

            return [
                'success'   => true,
                'message'   => 'Endereço detalhado com sucesso.',
                'data'      => AddressResource::make($endereco)
            ];
        } catch(\Exception $e){
            return [
                'success'   => false,
                'message'   => 'Falha ao detalhar o endereço. Erro: ' . $e->getMessage(),
                'data'      => []
            ];
        }
    }

    public function formatarDadosEndereco($dados){
        return [
            'idAddress'     => $dados['idAddress'] ?? null,
            'county'        => trim($dados['county']) ?? null,
            'streetNumber'  => trim($dados['streetNumber']) ?? null,
            'streetName'    => trim($dados['streetName']) ?? null,
            'addressLine2'  => trim($dados['addressLine2']) ?? null,
            'addressLine3'  => trim($dados['addressLine3']) ?? null,
            'city'          => trim($dados['city']) ?? null,
            'state'         => trim($dados['state']) ?? null,
            'zipCode'       => trim($dados['zipCode']) ?? null,
            'squareFootage' => trim($dados['squareFootage']) ?? null,
            'location'      => trim($dados['location']) ?? null,
            'latitude'      => $dados['latitude'] ?? null,
            'longitude'     => $dados['longitude'] ?? null,
            'needsRecoding' => $dados['needsRecoding'] ?? null,
        ];
    }
}
