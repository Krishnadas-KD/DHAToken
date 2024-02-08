<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\TokenDetails;
use App\Models\TokenSeries;
use Carbon\Carbon;

class TokenController extends Controller
{
    public function token_index()
    {
        $tokenDetails = TokenDetails::where('closed', '=', '0')->get();
        $data = ['cardsData' => $tokenDetails];
        return view('token-genrate', $data);
    }

    public function token_create(Request $request)
    {
        $user = Auth::user();

        $type=request('type');
        $section=request('section');
        $qry = TokenSeries::where('type', $type)
        ->where('section', $section)
        ->first();
        
        if ($qry) {
            $next_series = $qry->abbr . ($qry->current_sq+1);
            $qry->current_sq = $qry->current_sq + 1;
            $qry->save();            
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
