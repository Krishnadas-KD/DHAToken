<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\TokenDetails;
use App\Models\TokenWorkflows;
use Carbon\Carbon;

class TokenExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiry:tokenexpiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To closed the token not attened long time';

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

        try {
            $pending_tokens = TokenDetail::where('token_status', '=', 'Pending Registration')
            ->where('closed', '!=', 1)
            ->get();
            $servicer_time = Service ::where ('service_name','=','Registration')-first();

            foreach ($pending_tokens as $token) {
                $currentTime = Carbon::now();
                $created_at = Carbon::parse($token->created_at);
                $differenceInMinutes = $created_at->diffInMinutes($currentTime);

                if ($differenceInMinutes >= $servicer_time->service_time) {
                    TokenWorkFlows::create([
                        'token_name' => $pending_tokens->token_name,
                        'token_id' => $pending_tokens->token_id,
                        'service_name' => $servicer_time-> service_name,
                        'service_time' => $servicer_time-> service_time,
                        'counter_name' => 0,
                        'counter_number' => 0,
                        'section' => $pending_tokens->section,
                        'status' => 'Canceled',
                        'is_closed'=>'1',
                        'created_user' => 'System',
                        'comment'=>'System Timeout'
                    ]);
                }
            }

        } catch (Exception $e) {
           
            info( "Caught an exception: " . $e->getMessage());
        } 

         
        

    }
}
