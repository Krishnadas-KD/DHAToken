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
        $post_date=request('postingDate');

            $hour=[];
            $male=[];
            $female=[];
            $new_t=[];
            $renew_t=[];
            $totoalcount=[];
            $hourlyData=DB::table('token_details')->selectRaw('HOUR(DATE_ADD(created_at, INTERVAL 4 HOUR)) AS hour')
            ->selectRaw('SUM(CASE WHEN section = "MALE" THEN 1 ELSE 0 END) AS male')
            ->selectRaw('SUM(CASE WHEN section = "FEMALE" THEN 1 ELSE 0 END) AS female')
            ->selectRaw('SUM(CASE WHEN type = "NEW" THEN 1 ELSE 0 END) AS new_t')
            ->selectRaw('SUM(CASE WHEN type = "RENEW" THEN 1 ELSE 0 END) AS renew_t')
            ->selectRaw('COUNT(*) AS count')
            ->whereDate('post_date', $post_date)
            ->groupByRaw('HOUR(DATE_ADD(created_at, INTERVAL 4 HOUR))')
            ->get();
            foreach ($hourlyData as $row) {
                $index=0;
                if (in_array($row->hour, $hour))
                {
                      $index=array_search($row->hour, $hour);
                      $male[$index] +=  $row->male  === "MALE" ?  $row->count : 0;
                      $female[$index] += $row->male  === "FEMALE" ?  $row->count : 0;
                      $new_t[$index] += $row->male  === "RENEW" ?  $row->count : 0;
                      $renew_t[$index] += $row->male  === "NEW" ?  $row->count : 0;
                      $totoalcount[$index] += $row->count;
                }
                else
                {
                    $hour[] = $row->hour;
                    $male[] = $row->male  === "MALE" ?  $row->count : 0;
                    $female[] = $row->male  === "FEMALE" ?  $row->count : 0;
                    $new_t[] = $row->male  === "RENEW" ?  $row->count : 0;
                    $renew_t[] = $row->male  === "NEW" ?  $row->count : 0;
                    $totoalcount[] = $row->count;
                }
            }

            foreach ($hour as $h) {
                // Example: assuming "x" and "y" columns for chart
                $chartData[] = array("x" => $row['x'], "y" => $row['y']);
            }
          $chartData[] = array("x" => $hour, "y" => $totoalcount);
            
          $json=json_encode($chartData);     
        return response()->json(['message' => 'Success', 'data' => $json]);
        
    }
}
