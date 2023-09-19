<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Prognoz;
use Illuminate\Support\Facades\DB;

class ValidationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:match';

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
    public function handle()
    {

        $get_no_started = Prognoz::query()
        ->orderby('start_carbon', 'asc')->where('status', 'Начало')
        ->get();

        foreach ($get_no_started as $item) {
            if ($item->start_carbon <= Carbon::now() &&  Carbon::parse($item->start_carbon)->addMinutes(105) >= Carbon::now() ){
                $item->update([
                   'status' =>  'Начался'
                ]);
            }
        }
        $get_started = Prognoz::query()
            ->orderby('start_carbon', 'asc')->where('status', 'Начался')->get();
        foreach ($get_started as $item) {
            if ($item->start_carbon <= Carbon::now() && Carbon::parse($item->start_carbon)->addMinutes(105) <= Carbon::now() ){
                $item->update([
                   'status' =>  'Завершен'
                ]);
            }
        }

    }
}
