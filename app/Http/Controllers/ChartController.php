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
            $total=[];
            $registration=[];
            $blood=[];
            $x_ray=[];

            $hourlyData=DB::table('token_details')->selectRaw('HOUR(created_at) AS hour')
            ->selectRaw('COUNT(*) AS count')
            ->whereDate('post_date', $post_date)
            ->groupByRaw('HOUR(created_at)')
            ->get();

            $Registration=DB::table('token_workflows')->selectRaw('HOUR(created_at) AS hour, count(*) as count')
                     ->whereDate('created_at', $post_date)
                     ->where('service_name', 'Registration')
                     ->where('status', 'like', 'In%')
                     ->whereNotExists(function ($query) {
                          $query->select(DB::raw(1))
                                ->from('token_details')
                                ->whereColumn('token_details.id', 'token_workflows.token_id')
                                ->where('token_status', 'Canceled');
                      })
                     ->groupByRaw('HOUR(created_at)')->get();


            
            $Blood_Col=DB::table('token_workflows')->selectRaw('HOUR(created_at) AS hour, count(*) as count')
                     ->whereDate('created_at', $post_date)
                     ->where('service_name', 'Blood Collection')
                     ->where('status', 'like', 'In%')
                     ->groupByRaw('HOUR(created_at)')->get();


                
            $X_ray=DB::table('token_workflows')->selectRaw('hour(created_at) as hour, count(*) as count')
            ->whereDate('created_at', $post_date)
            ->where('service_name', 'X-Ray')
            ->where('status', 'like', 'In%')
            ->groupByRaw('HOUR(created_at)')->get();


             $data=['total'=> $this->hourAdder($hourlyData),'registration'=>$this->hourAdder($Registration),'blood'=> $this->hourAdder($Blood_Col),'x_ray'=> $this->hourAdder($X_ray)];
            return response()->json(['message' => 'Success', 'data' => $data]);
        }
        catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();
            return response()->json(['message' => 'Failed'], 500);
        }
            
        return response()->json(['message' => 'Success', 'data' => null]);
        
    }
    private function hourAdder($result)
    {
        $existingHours = $result->pluck('hour')->toArray();

        // Adding the missing hours with counts of 0
        for ($i = 0; $i < 24; $i++) {
            if (!in_array($i, $existingHours)) {
                $result->push((object) ['hour' => $i, 'count' => 0]);
            }
        }

        // Sorting the result by hour
        $result = $result->sortBy('hour')->values();
        return $result;
    }
 
}

