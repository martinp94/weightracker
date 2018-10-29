<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingPeriod extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'initial_weight', 
        'desired_weight', 
        'status',
        'tracking_end_date'
    ];
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tracking_period';

    public function isActive() 
    {
        return $this->status == true;
    }

    public function days()
    {
        return $this->hasMany('App\TrackingDay', 'tracking_period_id', 'id')->orderBy('measure_date');
    }
    
}
