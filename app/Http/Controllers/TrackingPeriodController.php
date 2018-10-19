<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TrackingPeriodService;

class TrackingPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Check if active tracking period exists.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkActivePeriod(TrackingPeriodService $trackingPeriodService) 
    {
        if(!$trackingPeriodService->activePeriodExists())
        {
            return response()->json(['message' => false]);
        }
        
        return response()->json([
            'message' => true,
            'period' => $trackingPeriodService->activePeriod()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TrackingPeriodService $trackingPeriodService)
    {
        if( $request['type'] == 'timed' )
            return $trackingPeriodService->storeTimed($request['initialWeight'], $request['endDate']);
        else if( $request['type'] == 'to_weight' )
            return $trackingPeriodService->storeToWeight($request['initialWeight'], $request['desiredWeight']);
        else
            return response()->json(['message' => 'Type must be selected'], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
