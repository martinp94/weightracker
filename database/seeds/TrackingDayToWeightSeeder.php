<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\TrackingDay;

class TrackingDayToWeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $latestPeriod = App\TrackingPeriod::latest()->first();

        $currentDate = \Carbon\Carbon::parse($latestPeriod->created_at);

        $initialWeight = $latestPeriod->initial_weight;
        $desiredWeight = $latestPeriod->desired_weight;
        $currentWeight = $initialWeight;
        
        while($currentWeight > $desiredWeight)
        {
            $currentDate = \Carbon\Carbon::parse($currentDate)->addDay();
            $randomLoss = $this->random_0_1();
            $lost = mt_rand(0, 1);

            if($lost == 0)
                $currentWeight += $randomLoss;
            else
                $currentWeight -= $randomLoss;

            DB::table('tracking_day')->insert([
                'tracking_period_id' => $latestPeriod->id,
                'weight' => number_format($currentWeight, 1),
                'measure_date' => $currentDate,
            ]);

            
        }
    }

    // auxiliary function
    // returns random number with flat distribution from 0 to 1
    private function random_0_1() 
    {
        return (float) mt_rand() / (float) mt_getrandmax();
    }
}
