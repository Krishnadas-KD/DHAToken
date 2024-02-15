<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Mail\DaliyCountMail;
use App\Models\AutoMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;



class TokenSqlClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:tokenSeries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear  token Series Evey day start';

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
            DB::table('token_series')->update(['current_sq' => 0]);
            info( "Toekn Clear Sucess ");   
        } catch (Exception $e) {
           
            info( "Caught an exception: " . $e->getMessage());
        } 

         try{ 
            $qry = AutoMail::where('report', 'daily-count')->get();
            foreach ($qry as $mail) {
                $recipientEmail = $mail->email; 
                Mail::to($recipientEmail)->send(new DaliyCountMail());
            }
        }
        catch (Exception $e) {

             info( "error  ". $e ); 
        }
        

    }
}
