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


            $hourlyData=DB::table('token_details')->selectRaw('HOUR(DATE_ADD(created_at, INTERVAL 4 HOUR)) AS hour')
            ->selectRaw('SUM(CASE WHEN section = "MALE" THEN 1 ELSE 0 END) AS male')
            ->selectRaw('SUM(CASE WHEN section = "FEMALE" THEN 1 ELSE 0 END) AS female')
            ->selectRaw('SUM(CASE WHEN type = "NEW" THEN 1 ELSE 0 END) AS new_t')
            ->selectRaw('SUM(CASE WHEN type = "RENEW" THEN 1 ELSE 0 END) AS renew_t')
            ->selectRaw('COUNT(*) AS count')
            ->whereDate('post_date', $post_date)
            ->groupByRaw('HOUR(DATE_ADD(created_at, INTERVAL 4 HOUR))')
            ->get();

        return response()->json(['message' => 'Success', 'data' => $hourlyData]);
        
    }
}
