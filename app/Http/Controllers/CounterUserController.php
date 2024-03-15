<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\TokenDetails;
use App\Models\TokenWorkflows;
use App\Models\Counter;
use App\Models\UserCounter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CounterUserController extends Controller
{
    public function counter_user_index()
    {
        $counters = Counter::select('id', 'counter_name', 'counter_number', 'counter_section')
                        ->selectSub(function ($query) {
                            $query->select('service_name')
                                ->from('counter_services')
                                ->join('services', 'services.id', '=', 'counter_services.service_id')
                                ->whereColumn('counter_services.counter_id', 'counters.id')
                                ->limit(1);
                        }, 'service')
                        ->selectSub(function ($query) {
                            $query->select('users.name')
                                ->from('user_counters')
                                ->join('users', 'users.id', '=', 'user_counters.user_id')
                                ->whereColumn('user_counters.counter_id', 'counters.id')
                                ->limit(1);
                        }, 'counter_user')
                        ->get();
        $data = ['counter_stat' => $counters];

        return view('counter-user-select', $data);
        
    }
    public function counter_selected(Request $request)
    {

        try{
                //db start
                DB::beginTransaction();
            $female=request('femalecounter');
            $male=request('malecounter');
            $user = Auth::user();

            $counter = ($male === null) ? $female : $male;

            
            $user_counter=UserCounter::where('user_id','=',$user->id)->first();

            if($user_counter)
            {
                
                DB::table('user_counters')
                ->where('counter_id', '=', $counter)
                ->update(['counter_id' => null]);
                
                DB::table('user_counters')
                ->where('user_id', '=', $user_counter->user_id)
                ->update(['counter_id' => $counter]);
    
            }
            else
            {
                DB::table('user_counters')
                ->where('counter_id', '=', $counter)
                ->update(['counter_id' => null]);
                UserCounter::create([
                    'counter_id' => $counter,
                    'user_id' => $user->id,
                    'crt_user' => $user->email,
                ]);
            }
            DB::commit();
            return redirect()->route('counter_user_token_call');
        }
        catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('counter_user_index');
        }
    }

    public function counter_user_token_call()
    {
        
        $user = Auth::user();

        $counter_user = DB::table('counter_services')
        ->select('users.id','users.type','users.name','users.email','counters.id','counters.counter_section', 'counters.counter_name', 'counters.counter_number', 'services.service_name', 'services.series_abbr','services.service_time', 'counters.is_bussy','counters.is_active')
        ->join('counters', 'counter_services.counter_id', '=', 'counters.id')
        ->join('user_counters', 'user_counters.counter_id', '=', 'counters.id')
        ->join('users', 'users.id', '=', 'user_counters.user_id')
        ->join('services', 'counter_services.service_id', '=', 'services.id')
        ->where('users.id', '=', $user->id)
        ->first();

        if (!is_null($counter_user) && !is_null($counter_user->counter_number))
        {
            $current_token=DB::table('token_workflows')
            ->select('token_workflows.id','token_workflows.token_name','token_workflows.section','token_details.type','token_workflows.service_name')
            ->join('token_details', 'token_details.id', '=', 'token_workflows.token_id')
            ->where('token_workflows.counter_number','=',$counter_user->counter_number)
            ->where('token_workflows.is_closed','=','0')
            ->where('token_details.closed','=','0')
            ->where('token_workflows.status','LIKE','In%')
            ->first();
        }
        else
        {
            $current_token=null;
        }

        $data = ['counter_user' => $counter_user,
                'current_token'=>$current_token,
                'cardsData'=>[]];

        return view('counter-user-page', $data);
    }


    public function counter_user_refreshcall()
    {
        $user = Auth::user();

        $counter_user = DB::table('counter_services')
        ->select('users.id','users.type','users.name','users.email','counters.id','counters.counter_section', 'counters.counter_name', 'counters.counter_number', 'services.service_name', 'services.series_abbr','services.service_time', 'counters.is_bussy')
        ->join('counters', 'counter_services.counter_id', '=', 'counters.id')
        ->join('user_counters', 'user_counters.counter_id', '=', 'counters.id')
        ->join('users', 'users.id', '=', 'user_counters.user_id')
        ->join('services', 'counter_services.service_id', '=', 'services.id')
        ->where('users.id', '=', $user->id)
        ->first();

        if (!is_null($counter_user) && !is_null($counter_user->counter_number))
        {
            $current_token=DB::table('token_workflows')
            ->select('token_workflows.id','token_workflows.token_name','token_workflows.section','token_details.type','token_workflows.service_name','token_details.is_x_ray')
            ->join('token_details', 'token_details.id', '=', 'token_workflows.token_id')
            ->where('token_workflows.counter_number','=',$counter_user->counter_number)
            ->where('token_workflows.is_closed','=','0')
            ->where('token_details.closed','=','0')
            ->where('token_workflows.status','LIKE','In%')
            ->first();
        }
        else
        {
            $current_token=null;
        }

        $data = ['current_token'=>$current_token];

        return response()->json(['message' => 'Success', 'data' => $data]);
    }

    public function token_next(Request $request, $id,$next)
    {
        try{
            //db start
            DB::beginTransaction();
            $user = Auth::user();

            $current_token = DB::table('token_workflows')
                            ->where('id','=',$id)
                            ->first();
            $counter_status = DB::table('counter_services')
            ->select('counters.id','counters.counter_section', 'counters.counter_name', 'counters.counter_number', 'services.service_name', 'services.series_abbr','services.service_time', 'counters.is_bussy')
            ->join('counters', 'counter_services.counter_id', '=', 'counters.id')
            ->join('services', 'counter_services.service_id', '=', 'services.id')
            ->where('counters.counter_number', '=', $current_token->counter_number)
            ->orderBy('counters.id')
            ->first();
            $counter_section = $counter_status->counter_section;
            $counter_name = $counter_status->counter_name;
            $counter_number = $counter_status->counter_number;
            $service_name = $counter_status->service_name;
            $service_time = $counter_status->service_time;

            if($service_name=="Registration"){
                $x_ray=request('xray');
                DB::table('token_details')
                ->where('id', $current_token->token_id)
                ->update(['is_x_ray' => $x_ray]);
            }
            //next status
            if ($current_token->service_name == "Registration") {
                $status = "Pending Blood Collection";
            } elseif ($service_name == "Blood Collection") {
                $status = "Pending X-Ray";
                if($next=="Completed"){
                    $status="Completed";
                }
            } elseif ($service_name == "X-Ray") {
                $status = "Completed";
            } else {
                $status = "Unknown Service";
            }

            $flow_existe=TokenWorkFlows::select('id')
                ->where('status','=',$status)
                ->where('token_id','=',$current_token->token_id)
                ->where('service_name','=',$service_name)
                ->first();
            
            if($flow_existe!=null)
            {
                throw new Exception("Value is null");
            }

            if ( $status=="Completed") {
                 TokenWorkFlows::create([
                    'token_name' => $current_token->token_name,
                    'token_id' => $current_token->token_id,
                    'service_name' => $service_name,
                    'service_time' => $service_time,
                    'counter_name' => $counter_name,
                    'counter_number' => $counter_number,
                    'section' => $counter_section,
                    'status' => $status,
                    'is_closed'=>'1',
                    'created_user' => $user->email
                ]);
                DB::table('token_details')
                    ->where('id', $current_token->token_id)
                    ->update(['token_status' => $status,'closed' => '1']);
        
                DB::table('token_workflows')
                    ->where('id', $id)
                    ->update(['is_closed' => '1']);
            }
            else{
                TokenWorkFlows::create([
                    'token_name' => $current_token->token_name,
                    'token_id' => $current_token->token_id,
                    'service_name' => $service_name,
                    'service_time' => $service_time,
                    'counter_name' => $counter_name,
                    'counter_number' => $counter_number,
                    'section' => $counter_section,
                    'status' => $status,
                    'created_user' => $user->email
                ]);
                
                DB::table('token_details')
                    ->where('id', $current_token->token_id)
                    ->update(['token_status' => $status]);
                DB::table('token_workflows')
                    ->where('id', $id)
                    ->update(['is_closed' => '1']);
            
            }
            DB::commit();
            return redirect()->route('counter_user_token_call');
        }
        catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('counter_user_token_call');
        }
        
    }



    public function token_cancel(Request $request, $id)
    {
        $user = Auth::user();
        $current_token = DB::table('token_workflows')
                        ->where('id','=',$id)
                        ->first();
        $reason=request('reason');
        $counter_status = DB::table('counter_services')
        ->select('counters.id','counters.counter_section', 'counters.counter_name', 'counters.counter_number', 'services.service_name', 'services.series_abbr','services.service_time', 'counters.is_bussy')
        ->join('counters', 'counter_services.counter_id', '=', 'counters.id')
        ->join('services', 'counter_services.service_id', '=', 'services.id')
        ->where('counters.counter_number', '=', $current_token->counter_number)
        ->orderBy('counters.id')
        ->first();
        $counter_id = $counter_status->id;
        $counter_section = $counter_status->counter_section;
        $counter_name = $counter_status->counter_name;
        $counter_number = $counter_status->counter_number;
        $service_name = $counter_status->service_name;
        $series_abbr = $counter_status->series_abbr;
        $service_time = $counter_status->service_time;
        
        $status="Canceled";

        $new_flow = TokenWorkFlows::create([
            'token_name' => $current_token->token_name,
            'token_id' => $current_token->token_id,
            'service_name' => $service_name,
            'service_time' => $service_time,
            'counter_name' => $counter_name,
            'counter_number' => $counter_number,
            'section' => $counter_section,
            'status' => $status,
            'comment'=>$reason,
            'is_closed'=>'1',
            'created_user' => $user->email
        ]);
        DB::table('token_details')
            ->where('id', $current_token->token_id)
            ->update(['token_status' => $status,'closed' => '1']);


        DB::table('token_workflows')
            ->where('id', $id)
            ->update(['is_closed' => '1']);
        
        return redirect()->route('counter_user_token_call');

    }
   
    public function counter_token_call(Request $request)
    {

        try{

            DB::beginTransaction();

            $user = Auth::user();
            $counter_user = DB::table('counter_services')
            ->select('users.id','users.type','users.name','users.email','counters.id as counter_id','counters.counter_section', 'counters.counter_name', 'counters.counter_number', 'services.service_name', 'services.series_abbr','services.service_time', 'counters.is_bussy','counters.is_active')
            ->join('counters', 'counter_services.counter_id', '=', 'counters.id')
            ->join('user_counters', 'user_counters.counter_id', '=', 'counters.id')
            ->join('users', 'users.id', '=', 'user_counters.user_id')
            ->join('services', 'counter_services.service_id', '=', 'services.id')
            ->where('users.id', '=', $user->id)
            ->first();

            $counter_name=$counter_user->counter_name;
            $counter_number=$counter_user->counter_number;
            $counter_section=$counter_user->counter_section;
            $service_name=$counter_user->service_name;
            $service_time=$counter_user->service_time;
          

            $counter_token_exists= TokenWorkFlows::select('token_name')
                ->where('counter_number','=',$counter_number)
                ->where('service_name','=',$service_name)
                ->where('status','like','In%')
                ->where('is_closed','=',0)
                ->first();

            
            if ($counter_token_exists!=null){
                
                throw new Exception("Value is null");
            } 
            $status="Pending ".$service_name;

            $token = TokenDetails::select('id', 'token_name', 'type', 'section', 'token_status')
            ->selectRaw('COALESCE((SELECT MAX(created_at) FROM token_workflows WHERE token_id = token_details.id), created_at) AS last_updated')
            ->where('section', '=', $counter_section)
            ->where('token_status', '=', $status)
            ->where('is_printed', '=', '1')
            ->where('closed', '=', '0')
            ->orderBy('last_updated', 'asc')->orderBy('token_name', 'asc')->lockForUpdate()
            ->first();
            
            if($token){
                DB::table('token_details')
                    ->where('id', $token->id)
                    ->update(['token_status' => "In " . $service_name]);
                DB::table('token_workflows')
                ->where('token_id', '=',$token->id)
                ->where('is_closed','=','0')
                ->where('status','=',$status)
                ->update(['is_closed' => '1']);
                DB::commit();
                $new_flow = TokenWorkFlows::create([
                    'token_name' => $token->token_name,
                    'token_id' => $token->id,
                    'service_name' => $service_name,
                    'service_time' => $service_time,
                    'counter_name' => $counter_name,
                    'counter_number' => $counter_number,
                    'section' => $counter_section,
                    'status' => "In " . $service_name,
                    'created_user' => $user->email
                ]);
                return response()->json(['message' => 'Success', 'data' => 'Done']);

            }
            DB::commit();
            return response()->json(['message' => 'No data', 'data' => 'None']);
        }
        catch (Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();
            return response()->json(['error' => 'Failed to retrieve token'], 500);
        }
    }

    public function counter_token_list_ajax()
    {

        $user = Auth::user();
        $counter_user = DB::table('counter_services')
        ->select('users.id','users.type','users.name','users.email','counters.id','counters.counter_section', 'counters.counter_name', 'counters.counter_number', 'services.service_name', 'services.series_abbr','services.service_time', 'counters.is_bussy')
        ->join('counters', 'counter_services.counter_id', '=', 'counters.id')
        ->join('user_counters', 'user_counters.counter_id', '=', 'counters.id')
        ->join('users', 'users.id', '=', 'user_counters.user_id')
        ->join('services', 'counter_services.service_id', '=', 'services.id')
        ->where('users.id', '=', $user->id)
        ->first();
        if (!is_null($counter_user) && !is_null($counter_user->counter_number))
        {
            $queue_token = TokenDetails::select('id', 'token_name', 'type', 'section', 'token_status','created_at','closed')
            ->selectRaw('COALESCE((SELECT MAX(created_at) FROM token_workflows WHERE token_id = token_details.id), created_at) AS last_updated')
            ->where('section', '=', $counter_user->counter_section)
            ->where('token_status', '=', "Pending ".$counter_user->service_name)
            ->where('closed', '!=', '1')
            ->orderBy('last_updated', 'asc')->orderBy('token_name', 'asc')->get();
        }
        else
        {
            $queue_token=null;
        }
        $data = ['queue_token'=>$queue_token];
        return response()->json(['message' => 'Success', 'data' => $data]);
    }

    public function counter_token_select_call_ajax($id)
    {
        DB::beginTransaction();
        try{
        
            $user = Auth::user();
            $counter_user = DB::table('counter_services')
            ->select('users.id','users.type','users.name','users.email','counters.id as counter_id','counters.counter_section', 'counters.counter_name', 'counters.counter_number', 'services.service_name', 'services.series_abbr','services.service_time', 'counters.is_bussy','counters.is_active')
            ->join('counters', 'counter_services.counter_id', '=', 'counters.id')
            ->join('user_counters', 'user_counters.counter_id', '=', 'counters.id')
            ->join('users', 'users.id', '=', 'user_counters.user_id')
            ->join('services', 'counter_services.service_id', '=', 'services.id')
            ->where('users.id', '=', $user->id)
            ->first();
            
           
            $counter_id = $counter_user->counter_id;
            $counter_name=$counter_user->counter_name;
            $counter_number=$counter_user->counter_number;
            $counter_section=$counter_user->counter_section;
            $service_name=$counter_user->service_name;
            $service_time=$counter_user->service_time;

            $status="Pending ".$service_name;


            $token = TokenDetails::select('id', 'token_name', 'type', 'section', 'token_status','closed')
            ->where('id', '=',$id)
            ->where('section', '=', $counter_section)
            ->where('token_status', '=', $status)
            ->where('is_printed', '=', '1')->lockForUpdate()->first();

            
        
            if($token){
                
                if($token->closed== 2)
                {
                    DB::table('token_details')
                    ->where('id', $token->id)
                    ->update(['closed' => '0']);
                }

                DB::table('token_details')
                    ->where('id', $token->id)
                    ->update(['token_status' => "In " . $service_name]);

                DB::table('token_workflows')
                ->where('token_id', '=',$token->id)
                ->where('is_closed','=','0')
                ->where('status','=',$status)
                ->update(['is_closed' => '1']);
                DB::commit();
                $new_flow = TokenWorkFlows::create([
                    'token_name' => $token->token_name,
                    'token_id' => $token->id,
                    'service_name' => $service_name,
                    'service_time' => $service_time,
                    'counter_name' => $counter_name,
                    'counter_number' => $counter_number,
                    'section' => $counter_section,
                    'status' => "In " . $service_name,
                    'created_user' => $user->email
                ]);
                return response()->json(['message' => 'Success', 'data' => 'Done']);
            }
            else{
                DB::commit();
            }

            return response()->json(['message' => 'No Data', 'data' => 'None']);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();
            return response()->json(['error' => 'Failed to retrieve token'], 500);
        }
 
    }
    public function token_hold_ajax(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $user = Auth::user();
            $current_token = DB::table('token_workflows')
                            ->where('id','=',$id)
                            ->first();
            $token_id=$current_token->token_id;
            $service_name=$current_token->service_name;
            DB::table('token_details')
            ->where('id', $token_id)
            ->update(['token_status' => "Pending " .$service_name,'closed' => '2']);
            DB::table('token_workflows')
            ->where('id', $id)
            ->update(['is_closed' => '1', 'status' => 'Hold']);
            DB::commit();
        }
        catch (Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();
            return redirect()->route('counter_user_token_call');
        }

    }



    }
