<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\TrackingDay;

class TrackingDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $weight = 87;

        for($i = 0; $i < 10; $i++)
        {

            $latestPeriod = App\TrackingPeriod::latest()->first();

            $currentDate = \Carbon\Carbon::parse(TrackingDay::where('tracking_period_id', '=', $latestPeriod->id)
                                                            ->orderBy('measure_datetime', 'desc')
                                                            ->first()->measure_datetime)
                                                            ->addDay();
            $randomLoss = $this->random_0_1();
            $lost = mt_rand(0, 1);

            if($lost == 0)
                $weight += $randomLoss;
            else
                $weight -= $randomLoss;

            DB::table('tracking_day')->insert([
                'tracking_period_id' => $latestPeriod->id,
                'weight' => number_format($weight, 1),
                'measure_datetime' => \Carbon\Carbon::parse($currentDate)->format('Y-m-d h:i:s'),
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
