<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Personal;
use App\Models\Contact;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Services\CreditService;

class LoanProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:loan_process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check CIC for fraud and credit';

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
        Log::info('Loan processing started.');
        print('Loan processing started.');

        $personals = Personal::where('cic_credit_check', 'PENDING')->get();
        if (sizeof($personals) == 0) return 0;

        $creditService = new CreditService();

        foreach ($personals as $personal) {
            $creditService->checkCredit($personal);
        }

        return 0;
    }
}
