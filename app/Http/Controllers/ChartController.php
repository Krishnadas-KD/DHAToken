<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\TokenDetails;
use App\Models\TokenWorkflows;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    
    public function chartData(Request $request)
    {
            try{
            $post_date=request('postingDate');
            $hour=[];
            $male=[];
            $female=[];
            $new_t=[];
            $renew_t=[];
            $totoalcount=[];
            $hourlyData=DB::table('token_details')->selectRaw('HOUR(created_at) AS hour')
            ->selectRaw('SUM(CASE WHEN section = "MALE" THEN 1 ELSE 0 END) AS male')
            ->selectRaw('SUM(CASE WHEN section = "FEMALE" THEN 1 ELSE 0 END) AS female')
            ->selectRaw('SUM(CASE WHEN type = "NEW" THEN 1 ELSE 0 END) AS new_t')
            ->selectRaw('SUM(CASE WHEN type = "RENEW" THEN 1 ELSE 0 END) AS renew_t')
            ->selectRaw('COUNT(*) AS count')
            ->whereDate('post_date', $post_date)
            ->groupByRaw('HOUR(created_at)')
            ->get();

            $Registration=DB::table('token_workflows')->selectRaw('hour(created_at) as hour, count(*) as count')
                     ->whereDate('created_at', $post_date)
                     ->where('service_name', 'Registration')
                     ->where('status', 'like', 'In%')
                     ->groupByRaw('HOUR(created_at)')->get();


            
            $Blood_Col=DB::table('token_workflows')->selectRaw('hour(created_at) as hour, count(*) as count')
                     ->whereDate('created_at', $post_date)
                     ->where('service_name', 'Blood Collection')
                     ->where('status', 'like', 'In%')
                     ->groupByRaw('HOUR(created_at)')->get();


                
            $X_ray=DB::table('token_workflows')->selectRaw('hour(created_at) as hour, count(*) as count')
            ->whereDate('created_at', $post_date)
            ->where('service_name', 'X-Ray')
            ->where('status', 'like', 'In%')
            ->groupByRaw('HOUR(created_at)')->get();

            foreach ($hourlyData as $row) {
                if (in_array($row->hour, $hour))
                {
                      $index=array_search($row->hour, $hour);
                      $male[$index] +=  $row->male  === "MALE" ?  $row->count : 0;
                      $female[$index] += $row->female  === "FEMALE" ?  $row->count : 0;
                      $new_t[$index] += $row->new_t  === "RENEW" ?  $row->count : 0;
                      $renew_t[$index] += $row->renew_t  === "NEW" ?  $row->count : 0;
                      $totoalcount[$index] += $row->count;
                }
                else
                {
                    $hour[] = $row->hour;
                    $male[] = $row->male  === "MALE" ?  $row->count : 0;
                    $female[] = $row->female  === "FEMALE" ?  $row->count : 0;
                    $new_t[] = $row->new_t  === "RENEW" ?  $row->count : 0;
                    $renew_t[] = $row->renew_t  === "NEW" ?  $row->count : 0;
                    $totoalcount[] = $row->count;
                }
            }
            
            foreach ($hour as $index => $h) {
                $total[] = array('x' => $h, 'y' => $totoalcount[$index]);
            }
            foreach ($Registration as $hour) {
                $registration[] = ['x' => $hour->hour, 'y' => $hour->count];
            }


            foreach ($Blood_Col as $hour) {
                $blood[] = ['x' => $hour->hour, 'y' => $hour->count];
            }
        
            foreach ($X_ray as $hour) {
                $x_ray[] = ['x' => $hour->hour, 'y' => $hour->count];
            }



             $data=['total'=>$total,'registration'=>$totalmail,'registration'=>$blood,'blood'=>$blood,'x_ray'=>$x_ray];
            return response()->json(['message' => 'Success', 'data' => $data]);
        }
        catch (\Exception $e) {
            dd($e);
            // Rollback the transaction if an error occurs
            DB::rollBack();
            return response()->json(['message' => 'Failed'], 500);
        }
            
        return response()->json(['message' => 'Success', 'data' => null]);
        
    }
}
