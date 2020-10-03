<?php

namespace App\Console\Commands;

use App\Services\AddressService;
use App\Services\StoreService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;

class ImportarDadosBancoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importar-base-dados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa os dados do arquivo store.csv (localizado na pasta storage/app) para a base de dados desafio-shipp.sqlite';

    protected $storeService;
    protected $addressService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StoreService $storeService, AddressService $addressService)
    {
        parent::__construct();
        $this->storeService      = $storeService;
        $this->addressService    = $addressService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->importarDadosCsv();
    }

    public function importarDadosCsv(){
        try{
            Log::info('Entrou na função ' . __FUNCTION__);

            //Verifica se a base de dados existe no caminho especificado no README.md
            if (!file_exists(database_path('desafio-shipp.sqlite'))){
                Log::info('Encerrendo execução pois a base de dados não existe no caminho especificado.');

                return [
                    'success'   => false,
                    'message'   => 'Encerrendo execução pois a base de dados não existe no caminho especificado.',
                    'data'      => []
                ];
            }

            //Verifica se o arquivo csv existe no caminho especificado no README.md
            if (!file_exists(storage_path('app/stores.csv'))){
                Log::info('Encerrendo execução pois o arquivo csv não existe no caminho especificado.');

                return [
                    'success'   => false,
                    'message'   => 'Encerrendo execução pois o arquivo csv não existe no caminho especificado.',
                    'data'      => []
                ];
            }

            $csv = Reader::createFromPath(storage_path('app/stores.csv'), 'r');
            $csv->setDelimiter(',');
            $csv->setHeaderOffset(0);

            for($i = 0; $i < $csv->count(); $i++){
                $conteudoCsv = $csv->getRecords();
            }

            $conteudoCsv = collect($conteudoCsv);
            $conteudoCsv = $conteudoCsv->toArray($conteudoCsv);

            $chunks = array_chunk($conteudoCsv, 5000);

            foreach($chunks as $chunk){
                foreach($chunk as $linha){
                    $linha = $this->converterKeyArray($linha);

                    // Cadastra o endereço
                    $enderecoCadastrado = $this->addressService->inserirEndereco($linha);

                    if(!$enderecoCadastrado['success']){
                        Log::info('Falha ao inserir a linha ' . json_encode($linha));

                        continue;
                    }

                    $enderecoCadastrado['data'] = collect($enderecoCadastrado['data']);

                    $linha['idAddress'] = $enderecoCadastrado['data']['idAddress'];

                    $lojaCadastrada = $this->storeService->inserirLoja($linha);

                    if(!$lojaCadastrada['success']){
                        Log::info('Falha ao inserir a linha ' . json_encode($linha));

                        continue;
                    }
                }
            }

            Log::info('Finalizou a importação dos dados csv');

            return [
                'success'   => true,
                'message'   => 'Dados do csv importados com sucesso.',
                'data'      => []
            ];

        } catch(\Exception $e){
            Log::info('Falha ao importar os dados do csv. Erro: ' . $e->getMessage());

            return [
                'success'   => false,
                'message'   => 'Falha ao importar os dados do csv. Erro: ' . $e->getMessage(),
                'data'      => []
            ];
        }
    }

    public function converterKeyArray($linha){
        foreach($linha as $key => $registro){
            switch (mb_strtolower($key, 'utf-8')){
                case "license number":
                    $linha['licenseNumber'] = $registro;
                    unset($linha[$key]);

                    break;
                case "operation type":
                    $linha['operationType'] = $registro;
                    unset($linha[$key]);

                    break;
                case "establishment type":
                    $linha['establishmentType'] = $registro;
                    unset($linha[$key]);

                    break;
                case "entity name":
                    $linha['entityName'] = $registro;
                    unset($linha[$key]);

                    break;
                case "dba name":
                    $linha['dbaName'] = $registro;
                    unset($linha[$key]);

                    break;
                case "county":
                    $linha['county'] = $registro;
                    unset($linha[$key]);

                    break;
                case "street number":
                    $linha['streetNumber'] = $registro;
                    unset($linha[$key]);

                    break;
                case "street name":
                    $linha['streetName'] = $registro;
                    unset($linha[$key]);

                    break;
                case "address line 2":
                    $linha['addressLine2'] = $registro;
                    unset($linha[$key]);

                    break;
                case "address line 3":
                    $linha['addressLine3'] = $registro;
                    unset($linha[$key]);

                    break;
                case "city":
                    $linha['city'] = $registro;
                    unset($linha[$key]);

                    break;
                case "state":
                    $linha['state'] = $registro;
                    unset($linha[$key]);

                    break;
                case "zip code":
                    $linha['zipCode'] = $registro;
                    unset($linha[$key]);

                    break;
                case "square footage":
                    $linha['squareFootage'] = $registro;
                    unset($linha[$key]);

                    break;
                case "location":

                    // Retira as aspas
                    $location = str_replace('"', '', $linha[$key]);
                    $location = str_replace("'", "", $location);

                    // Pega a latitude
                    $latitude = explode('latitude: ', $location);
                    $latitude = (isset($latitude[1])) ? preg_replace("/[^0-9\.]/", '', $latitude[1]) : '';

                    // Pega a longitude
                    $longitude = explode('longitude: ', $location);
                    $longitude = (isset($longitude[1])) ? explode(',', $longitude[1])[0] : '';

                    $needsRecoding = explode('needs_recoding: ', $location);
                    $needsRecoding = (isset($needsRecoding[1])) ? mb_strtolower(explode(',', $needsRecoding[1])[0], 'utf-8') : '';

                    // Transforma a string "true" ou "false" em boolean
                    $needsRecoding = $needsRecoding == "true" ? true : false;

                    $linha['latitude']      = $latitude;
                    $linha['longitude']     = $longitude;
                    $linha['needsRecoding'] = $needsRecoding;

                    $linha['location'] = $registro;
                    unset($linha[$key]);

                    break;
                default:
                    $key = null;
            }
        }

        return $linha;
    }
}
