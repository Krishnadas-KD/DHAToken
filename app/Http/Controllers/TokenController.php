<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TokenDetails;
use App\Models\TokenSeries;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    public function token_index()
    {
        $tokenDetails = TokenDetails::where('closed', '=', '0')->get();
        $section=TokenSeries::select('section')->distinct()->get();
        $type=TokenSeries::select('type')->distinct()->get();
        $data = ['cardsData' => $tokenDetails,'section'=>$section,'type'=>$type];
        return view('token-genrate', $data);
    }

    public function token_create(Request $request)
    {
        $user = Auth::user();
        $random_number = 0;

        $type=request('type');
        $section=request('section');
        $qry = TokenSeries::where('section', $section)
        ->where('type', $type)
        ->first();
        
        if ($qry) {
            if ($qry->current_sq%60===0 &&$qry->current_sq>0)
            {
                $random_number = rand(10, 100);
            }
            $next_series = $qry->abbr . ($qry->current_sq+1 +($random_number));
            TokenSeries::where('abbr', $qry->abbr)
            ->where('section', $qry->section)
            ->update(['current_sq' => $qry->current_sq+1 +($random_number)]);
        } else {
            $next_series = null;
        }

        $token_name=$next_series;
        $customer_token = TokenDetails::create([
            'type' => $type,
            'token_name' => $token_name,
            'section' => $section,
            'crt_user' => $user->email,
            'is_printed'=>true,
            'last_print'=>Carbon::now(),
            'print_count'=>'1'
        ]);
        $data = ['customer_token' => $customer_token];
        return response()->json(['message' => 'Success', 'data' => $data]);
    }


    public function reprint_token($id)
    {
        $customer_token = TokenDetails::find($id);
        $qry = TokenDetails::find($id);
        if ($id)
        {
            $qry->print_count=$qry->print_count+1;
            $qry->is_printed=1;
            $qry->last_print = Carbon::now();
            $qry->save();
        }
        $data = ['customer_token' => $customer_token];
        return response()->json(['message' => 'Success', 'data' => $data]);

    }
    public function token_list_ajax()
    {
        $tokenDetails = TokenDetails::where('closed', '=', '0')->get();
        $data = ['cardsData' => $tokenDetails];
        return response()->json(['message' => 'Success', 'data' => $data]);
    }
}
