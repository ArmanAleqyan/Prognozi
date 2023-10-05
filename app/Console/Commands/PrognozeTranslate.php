<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TranslateController;
use Illuminate\Contracts\Translation\Translator;

class PrognozeTranslate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prognoz:translate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(Translator $translator)
    {
        $homeController = new TranslateController();
        $homeController->translate_prognoz();
//        $homeController->translate_atribute_test();
        $homeController->translate_atribute_testv2($translator);
        $homeController->translate_country();
    }
}
