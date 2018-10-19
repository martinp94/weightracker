<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\TrackingPeriod;

class TrackingPeriodService
{
    protected $trackingPeriod;

    public function __construct(TrackingPeriod $tp) 
    {
        $this->trackingPeriod = $tp;
    }

    private function store(array $data)
    {
        try 
        {
            TrackingPeriod::create($data);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['message' => $e->errorInfo], 422);
        }
    }

    public function storeTimed($initWeight, $endDate) 
    {
        if($this->activePeriodExists()) 
            return response()->json(['message' => 'Active period exists'], 422);

        if(!isset($initWeight, $endDate)) 
            return response()->json(['message' => 'Initial weight and end date must be entered'], 422);

        $formatedDate = $this->formatDate($endDate);

        $data = [
            'user_id' => Auth::user()->id,
            'initial_weight' => $initWeight,
            'tracking_end_date' => $formatedDate,
            'status' => true
        ];

        $this->store($data);

    }

    public function storeToWeight($initWeight, $desiredWeight) 
    {
        if($this->activePeriodExists()) 
            return response()->json(['message' => 'Active period exists'], 422);

        if(!isset($initWeight, $desiredWeight)) 
            return response()->json(['message' => 'Initial and desired weight must be entered'], 422);

        $data = [
            'user_id' => Auth::user()->id,
            'initial_weight' => $initWeight,
            'desired_weight' => $desiredWeight,
            'status' => true
        ];

        $this->store($data);
        
    }

    private function formatDate($date) 
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }

    public function activePeriod() 
    {
        return TrackingPeriod::where('user_id', '=', Auth::user()->id)->where('status', '=', true)->first();
    }

    public function activePeriodExists() 
    {
        return TrackingPeriod::where('user_id', '=', Auth::user()->id)->where('status', '=', true)->count() ? true : false;
    }
}