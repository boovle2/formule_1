<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualifyingResult extends Model
{
    protected $table = 'qualifying_results';

    protected $fillable = [
        'qualifying_race_id',
        'driver_id',
        'placement',
        'time',
    ];

    public $timestamps = false;

    public function driver()
    {
        return $this->belongsTo(DriverModel::class, 'driver_id');
    }

    public function qualifyingRace()
    {
        return $this->belongsTo(QualifyingRaceModel::class, 'qualifying_race_id');
    }
}
