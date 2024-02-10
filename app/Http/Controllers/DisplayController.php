<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DisplayController extends Controller
{
   
    public function index()
    {
        $counters = Counter::latest()->paginate(5);

        $data = [
            'ajxa_url'=>'/test/test',
            'counters' => $counters
        ];
        return view('home', $data);
    }

    public function display_ajax(Request $request, $service,$section)
    {
         $token_status = DB::table('counter_services')
            ->select('counters.counter_name', 'token_workflows.token_name', 'token_workflows.section')
            ->join('counters', 'counters.id', '=', 'counter_services.counter_id')
            ->join('services', 'services.id', '=', 'counter_services.service_id')
            ->leftJoin('token_workflows', function ($join) use ($service) {
                $join->on('token_workflows.counter_number', '=', 'counters.counter_number')
                    ->where('token_workflows.is_closed', 0)
                    ->where('token_workflows.status', 'In ' . $service);
            })
            ->where('services.service_name', $service)
            ->where('counters.counter_section', $section)
            ->distinct()
            ->orderBy('counters.counter_name')
            ->get();
            
            $status = "Pending " . $service;

            $pending_token =  DB::table('token_details')->select('id', 'token_name', 'type', 'section', 'token_status','created_at')
            ->selectRaw('COALESCE((SELECT MAX(created_at) FROM token_workflows WHERE token_id = token_details.id), created_at) AS last_updated')
            ->where('section', '=',$section)
            ->where('token_status', '=', $status)
            ->where('closed', '=', '0')
            ->where('is_printed', 1)
            ->orderBy('last_updated', 'asc')->orderBy('token_name', 'asc')->take(40)->get();

        $data = [
            'counters' => $token_status,
            'pendingtoken'=>$pending_token
        ];
        return response()->json(['message' => 'Success', 'data' => $data]);

    }
    public function display_route(Request $request, $service,$section)
    {
        $url='/display-get/'.$service.'/'.$section;
        $data = [
            'ajxa_url'=>$url,
            'service'=>$service
        ];
        return view('display', $data);
    }
   
}
