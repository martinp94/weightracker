<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\TrackingPeriod;
use App\TrackingDay;

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
            $createdPeriod = TrackingPeriod::create($data);

            
            
            try 
            {
                TrackingDay::create([
                    'tracking_period_id' => $createdPeriod->id, 
                    'weight' => $createdPeriod->initial_weight, 
                    'measure_datetime' => $createdPeriod->created_at,
                ]);
            }
            catch (\Exception $e) 
            {
                return response()->json(['message' => $e->errorInfo], 422);
            }
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
        
        return $this->store($data);
       
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

        return $this->store($data);
        
    }

    private function formatDate($date) 
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }

    private function calculateTimedProgress($startingDate, $endingDate, $today)
    {
        $totalDays = \Carbon\Carbon::parse($startingDate)->startOfDay()->diffInDays(\Carbon\Carbon::parse($endingDate)) - 1;
        $daysPassed = \Carbon\Carbon::parse($startingDate)->startOfDay()->diffInDays(\Carbon\Carbon::parse($today)->startOfDay());
        return ceil(($daysPassed/$totalDays) * 100);
    }

    private function calculateToWeightProgress()
    {
        
    }

    private function calculateProgress(TrackingPeriod $period, TrackingDay $day) 
    {
        if($period->desired_weight == null)
        {
            return $this->calculateTimedProgress($period->created_at, $period->tracking_end_date, $day->measure_datetime);
        }
        else
        {
            return $this->calculateToWeightProgress();
        }
        
    }

    public function days($tracking_period_id) 
    {
        $period = TrackingPeriod::find($tracking_period_id);
        $days = $period->days;

        foreach($days as $day) 
        {
            $day['progress'] = $this->calculateProgress($period, $day);
        }

        return $days;
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