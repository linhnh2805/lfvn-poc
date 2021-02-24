<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SmsService;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test anything you want';

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
        $this->test_sms();
        // $str = 'C\u00e1c th\u00f4ng tin client l\u00e0 kh\u00f4ng \u0111\u00fang';
        // $dest = $this->convert_utf8($str);
        // print($dest);

        return 0;
    }

    function change_format($str) {
        if (empty($str)) return "";
    
        $date = str_replace('/', '-', $str);
        return date('Y-m-d', strtotime($date));
    }

    function test_sms() {
        $smsService = new SmsService();
        $smsService->sendSms('0985891285', '123454');
    }

    private function convert_utf8($str) {
        $result = mb_convert_encoding(
            preg_replace("/\\\\u([0-9a-f]{4})/"
                ,"&#x\\1;"
                ,$str
            )
            ,"UTF-8"
            ,"HTML-ENTITIES"
        );
        return $result;
      }
}
