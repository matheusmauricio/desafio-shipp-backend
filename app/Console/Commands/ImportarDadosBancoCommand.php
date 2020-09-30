<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\StoreController;
use Illuminate\Console\Command;

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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(StoreController $storeController)
    {
        $storeController->importarDadosCsv();
    }
}
