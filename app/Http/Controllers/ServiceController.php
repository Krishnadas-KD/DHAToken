<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::latest()->paginate(5);

        $data = [
            'services' => $services
        ];
        return view('services', $data);
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
                'service_name' => 'required|unique:services,service_name',
                'series_abbr' => 'required|unique:services,series_abbr',
                'crt_user' => 'required',
                'service_time' => 'required',
            ],
            [
                'series_abbr.unique' => 'Abbr already exist',
                'service_name.unique' => 'Service already exist'
            ]
        );

        $service = Service::create($request->all());

        return redirect()->route('service.index')
            ->with('success', $service->service_name . 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('edit-service', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('edit-service', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service_name' => 'required',
            'series_abbr' => 'required',
            'crt_user' => 'required',
            'service_time' => 'required',
        ]);


        $service->update($request->all());

        return redirect()->route('service.index')
            ->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('service.index')
            ->with('success', $service->service_name . ' Service deleted successfully');
    }
}
