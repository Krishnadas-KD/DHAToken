<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TokenDetails;
use App\Models\TokenSeries;
use Carbon\Carbon;
class ReportsController extends Controller
{
   
    public function index()
    {
        return view('home');
    }
    public function token_count_home(Request $request)
    {
        $data = [
            'user_counts' => null,
            'users' => null
        ];
        return view('report-token-count', $data);
    }
    public function token_count(Request $request)
    {
        $from_date =request('from');
        $to_date =request('to');
        $type =request('type');
        $section =request('section');
        $status =request('status');
        $result = TokenDetails::whereBetween('post_date', [$from_date, $to_date])
            ->when($section != 'all', function ($query) use ($section) {
                return $query->where('section', $section);
            })
            ->when($type != 'all', function ($query) use ($type) {
                return $query->where('type', $type);
            })
            ->when($status == 'Cancelled', function ($query) use ($status) {
                return $query->whereIn('token_status', ['Pending Registration','Canceled']);
            })
            ->when($status == 'Completed', function ($query) use ($status) {
                return $query->whereNotIn('token_status', ['Pending Registration','Canceled']);
            })
            ->groupBy('type', 'section')
            ->select('type', 'section', DB::raw('COUNT(*) as count'))
            ->get();

                
            //dd($result);
        return response()->json(['data' => $result]);
    }

    public function token_list_home(Request $request)
    {
        $data = [
            'user_counts' => null,
            'users' => null
        ];
        return view('report-token-list', $data);
    }
    public function token_list(Request $request)
    {
        $from_date =request('from');
        $to_date =request('to');
        $result = TokenDetails::select(
            'id',
            'token_name',
            'type',
            'section',
            'post_date',
            'token_status',
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as created_at"),
            DB::raw('(SELECT MAX(tw.updated_at) FROM token_workflows tw WHERE tw.token_id = token_details.id) as last_updated')
        )
        ->whereBetween('post_date', [$from_date, $to_date])
        ->get();
        
        return response()->json(['data' => $result]);
    }
   
}
