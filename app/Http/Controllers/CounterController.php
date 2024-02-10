<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counters = Counter::all();

        $data = [
            'counters' => $counters
        ];
        return view('counter', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'counter_name' => 'required|unique:counters,counter_name',
                'counter_number' => 'required|unique:counters,counter_number',
                'counter_section' => 'required',
                'crt_user' => 'required',
            ],
            [
                'counter_name.unique' => 'Name already exist',
                'counter_number.unique' => 'Number already exist'
            ]
        );

        $counter = Counter::create($request->all());

        return redirect()->route('counter.index')
            ->with('success', $counter->counter_name . ' Counter created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Counter  $counter
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Counter  $counter
     * @return \Illuminate\Http\Response
     */
    public function edit(Counter $counter)
    {
        return view('edit-counter', compact('counter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Counter  $counter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Counter $counter)
    {
        $request->validate([
            'counter_name' => 'required',
            'counter_number' => 'required',
            'counter_section' => 'required',
            'crt_user' => 'required'
        ]);


        $counter->update($request->all());

        return redirect()->route('counter.index')
            ->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Counter  $counter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Counter $counter)
    {
        $counter->delete();

        return redirect()->route('counter.index')
            ->with('success', $counter->counter_name . ' Counter deleted successfully');
    }
}
