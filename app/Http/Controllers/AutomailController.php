<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TokenDetails;
use App\Models\TokenSeries;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\DaliyCountMail;
use App\Models\AutoMail;
use Illuminate\Support\Facades\Auth;


class AutomailController extends Controller
{

   

    public function auto_mail_home(Request $request)
    {
        $automail = AutoMail::all();
        $data = [
            'automail' => $automail
        ];
        return view('automail-add', $data);
    }
    public function add_auto_mail(Request $request)
    {
        $user = Auth::user();

        $email =request('email');
        $report =request('report');
       
        $customer_token = AutoMail::create([
            'email' => $email,
            'report' => $report,
            'active' => 1,
            'crt_user' => $user->email,
            
        ]);
        return redirect()->route('auto_mail_home')
          ->with('success', ' Email added to Auto mail');
    }
    public function delete_auto_mail(Request $request)
    {
        $automailid = $request->id;
        $obj = AutoMail::find($automailid);
        $obj->delete();

        return redirect()->route('auto_mail_home')
            ->with('success','Deleted successfully');
    }


}
