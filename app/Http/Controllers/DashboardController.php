<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Counter;
use App\Models\UserCounter;
use App\Models\CounterService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {

      
        return view('welcome');
    }

    public function new_user()
    {

        $users = User::latest()->paginate(5);

        $data = [
            'users' => $users
        ];
        return view('newuser', $data);
    }


    public function create_user(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'type' => ['required'],
        ]);

        $newuser = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'type' => request('type'),
            'password' => Hash::make(request('password')),
        ]);

        $users = User::latest()->paginate(5);

        $data = [
            'users' => $users,
            'newuser' => $newuser,
        ];


        return redirect()->route('new_user', $data)
            ->with('success', $newuser->name . ' User created sucessfully.');

        // return view('newuser', $data);
    }
    public function destroy(Request $request)
    {
        $userid = $request->id;
        $user_obj = User::find($userid);
        $user_obj->delete();

        return redirect()->route('new_user')
            ->with('success', $user_obj->name . ' User deleted successfully');
    }

    public function edit_user(Request $request,User $user)
    {
        $userid = $request->id;
        $user_obj = User::find($userid);

        $data = [
            'user_obj' => $user_obj
        ];

        return view('edit-user', $data);
    }

    public function update_user(Request $request, $id)
    {

       
         $type = request('type');
        $pass = $request->input('password');
        // $user->password = Hash::make($pass);
        // $user->save();

        User::find($id)->update(['password'=> Hash::make($pass)]);
        User::find($id)->update(['type'=>$type]);

        //$user->update($request->all());

        return redirect()->route('new_user')
            ->with('success', 'User updated successfully');
    }
    public function assign_counter()
    {

        $counters = DB::table('counters')
            ->select('counters.counter_name','counters.id','counters.counter_number')
            ->leftJoin('counter_services', 'counter_services.counter_id', '=', 'counters.id')
            ->whereNull('counter_services.counter_id')
            ->orderBy('counters.id')
            ->get();

        $services = Service::all();

        //  $counterservices = CounterService::all();

        $counter_ass = DB::table('counter_services')
            ->select('counter_services.id', 'counter_services.counter_id', 'counter_services.service_id', 'counters.counter_name', 'counters.counter_number', 'services.service_name', 'services.series_abbr')
            ->join('counters', 'counter_services.counter_id', '=', 'counters.id')
            ->join('services', 'counter_services.service_id', '=', 'services.id')
            ->orderBy('counters.id')
            ->get();

        $data = [
            'counters' => $counters,
            'services' => $services,
            'counterservices' => $counter_ass,
        ];
        return view('assign-counter', $data);
    }

    public function assign_counter_no(Request $request)
    {

        $counter_id = $request->counter_id;

        $request->validate([
            'counter_id' => ['required', 'int'],
            'service_id' => ['required', 'int'],
            'crt_user' => ['required'],
        ]);

        $checkexist = CounterService::select('*')
            ->where('counter_id', '=', request('counter_id'))
            ->where('service_id', '=', request('service_id'))
            ->get();

        $count = CounterService::where(['counter_id' => request('counter_id'), 'service_id' => request('service_id')])->count();

        if ($count > 0) {
            return redirect()->route('assign_counter')
                ->with('exist', ' Duplicate entry');
        } else {
            $counterservice = CounterService::create([
                'counter_id' => request('counter_id'),
                'service_id' => request('service_id'),
                'crt_user' => request('crt_user'),
            ]);

            return redirect()->route('assign_counter')
                ->with('success', 'Counter assigned successfully');
        }
    }

    public function delete_ass_counter(Request $request)
    {
        $cs_id = $request->id;
        $cs_obj = CounterService::find($cs_id);
        $cs_obj->delete();

        return redirect()->route('assign_counter')
            ->with('success', 'Entry deleted successfully');
    }

    public function assign_user()
    {



        $usedCounterIds = UserCounter::pluck('counter_id')->all();
        $usedUserIds = UserCounter::pluck('user_id')->all();

        $countersNotInUse = Counter::whereNotIn('id', $usedCounterIds)->get();
        $usersNotInUse = User::whereNotIn('id', $usedUserIds)
                        ->where('type', 'Counter')
                        ->get();

        //  $counterservices = CounterService::all();

        $user_ass = DB::table('user_counters')
            ->select('user_counters.id', 'user_counters.counter_id', 'user_counters.user_id', 'counters.counter_name', 'counters.counter_number', 'users.name', 'users.email')
            ->join('counters', 'user_counters.counter_id', '=', 'counters.id')
            ->join('users', 'user_counters.user_id', '=', 'users.id')
            ->orderBy('users.id')
            ->get();

        $data = [
            'counters' => $countersNotInUse,
            'users' => $usersNotInUse,
            'counterusers' => $user_ass,
        ];
        return view('assign-user', $data);
    }

    public function assign_user_no(Request $request)
    {

        $counter_id = $request->counter_id;

        $request->validate([
            'user_id' => ['required', 'int'],
            'counter_id' => ['required', 'int'],
            'crt_user' => ['required'],
        ]);

        $count = UserCounter::where(['counter_id' => request('counter_id'), 'user_id' => request('user_id')])->count();

        if ($count > 0) {
            return redirect()->route('assign_user')
                ->with('exist', ' Duplicate entry');
        } else {
            $counteruser = UserCounter::create([
                'counter_id' => request('counter_id'),
                'user_id' => request('user_id'),
                'crt_user' => request('crt_user'),
            ]);

            return redirect()->route('assign_user')
                ->with('success', 'User assigned successfully');
        }
    }

    public function delete_ass_user(Request $request)
    {
        $cs_id = $request->id;
        $cs_obj = UserCounter::find($cs_id);
        $cs_obj->delete();

        return redirect()->route('assign_user')
            ->with('success', 'Entry deleted successfully');
    }

   

}
