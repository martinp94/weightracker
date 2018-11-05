<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingDay extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tracking_period_id', 
        'weight', 
        'measure_date',
    ];
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tracking_day';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getMeasureDatetimeAttribute($value) 
    {
        return \Carbon\Carbon::parse($value)->format('d. M Y');
    }
}
